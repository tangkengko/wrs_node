<?php 

require_once "db_config.php";

if($_POST['event_action']=="addNode")
{
	$cur_branch = $_POST['curNode'];

	$sql_sub_branch = 'SELECT * FROM tree where branch = ? ORDER BY branch,sub_branch asc;';
    $stmt_sub_branch = $wrs_node->prepare($sql_sub_branch);
    $stmt_sub_branch->execute(array($cur_branch));

    $xrs_sub_branch = $stmt_sub_branch->fetchAll();

    $new_sub_branch = $cur_branch.".".(count($xrs_sub_branch)+1);

	$sql_sub_branch_insert = 'INSERT INTO tree SET branch = ?, sub_branch = ?';
    $stmt_sub_branch_insert = $wrs_node->prepare($sql_sub_branch_insert);
    $stmt_sub_branch_insert->execute(array($cur_branch,$new_sub_branch));
}
elseif($_POST['event_action']=="deleteNode")
{
	$cur_branch = $_POST['curNode'];

	deleteNode($cur_branch);

}
elseif($_POST['event_action']=="displayAll")
{
	$xretobj="root <a href=\"#\" onclick=\"addNode('1')\"> + </a>";;
	$xretobj.="<br>";
	$xretobj.=displayBranch(1);
}

function displayBranch($sub_branch)
{
	global $wrs_node;
	$nodeStr="";

	$spacer="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";

	$sql_sub_branch = 'SELECT * FROM tree where branch = ? ORDER BY branch,sub_branch asc;';
    $stmt_sub_branch = $wrs_node->prepare($sql_sub_branch);
    $stmt_sub_branch->execute(array($sub_branch));

    $xrs_sub_branch = $stmt_sub_branch->fetchAll();

    if(count($xrs_sub_branch)>0)
    {
    	$last_rec = end($xrs_sub_branch);

        foreach ($xrs_sub_branch as $key => $rs_sub_branch)
        {
    		$spacer_repeat = count(explode(".", $rs_sub_branch['sub_branch']))-1;

    		$str_spacer = str_repeat($spacer, $spacer_repeat);

			// $nodeStr.="{$str_spacer} {$rs_sub_branch['branch']} - {$rs_sub_branch['sub_branch']}";
			$nodeStr.="{$str_spacer} node";

			$nodeStr.=" <a href=\"#\" onclick=\"addNode('".$rs_sub_branch['sub_branch']."')\"> + </a>&nbsp;<a href=\"#\" onclick=\"deleteNode('".$rs_sub_branch['sub_branch']."')\"> - </a> ";

	    	$nodeStr.="<br>";

	    	$sub_branch = $rs_sub_branch['sub_branch'];

	    	$nodeStr.=displayBranch($sub_branch);
        }

        return $nodeStr;
    }
    else
    {
    	return false;
    }
}

function deleteNode($sub_branch)
{
	global $wrs_node;

	$sql_sub_branch = 'SELECT * FROM tree where branch = ? ORDER BY branch,sub_branch asc;';
    $stmt_sub_branch = $wrs_node->prepare($sql_sub_branch);
    $stmt_sub_branch->execute(array($sub_branch));

    $xrs_sub_branch = $stmt_sub_branch->fetchAll();

    if(count($xrs_sub_branch)>0)
    {
    	$last_rec = end($xrs_sub_branch);

        foreach ($xrs_sub_branch as $key => $rs_sub_branch)
        {
	    	deleteNode($rs_sub_branch['sub_branch']);
        }

        $sql_sub_branch_delete = 'DELETE FROM tree where branch = ?';
	    $stmt_sub_branch_delete = $wrs_node->prepare($sql_sub_branch_delete);
	    $stmt_sub_branch_delete->execute(array($sub_branch));

	    $sql_sub_branch_delete = 'DELETE FROM tree where sub_branch = ?';
	    $stmt_sub_branch_delete = $wrs_node->prepare($sql_sub_branch_delete);
	    $stmt_sub_branch_delete->execute(array($sub_branch));

    }
    else
    {

    	$sql_sub_branch = 'SELECT * FROM tree where sub_branch = ? ORDER BY branch,sub_branch asc;';
	    $stmt_sub_branch = $wrs_node->prepare($sql_sub_branch);
	    $stmt_sub_branch->execute(array($sub_branch));

	    $xrs_sub_branch = $stmt_sub_branch->fetchAll();

	    if(count($xrs_sub_branch)>0)
	    {
	        foreach ($xrs_sub_branch as $key => $rs_sub_branch)
	        {
			    $sql_sub_branch_delete = 'DELETE FROM tree where sub_branch = ?';
			    $stmt_sub_branch_delete = $wrs_node->prepare($sql_sub_branch_delete);
			    $stmt_sub_branch_delete->execute(array($rs_sub_branch['sub_branch']));
	        }

	        return false;
	    }
    }
}

echo json_encode($xretobj);
?>