<?php
// This class handles different levels of pagination across website (both ajax and normal)
class pagination {
	    
	// prepare ajax pagination script
	function ajax_pagination_v2($total_records, $pagesize, $selectedpage)
	{
		$script = "";
		$totalpages = ceil($total_records/$pagesize);
		if ($totalpages < 1)
		  return "";
		 
		$arr = pagination::simple_pagination_links($totalpages,7,$selectedpage);
		$totallinks = count($arr);
		if($totallinks > 1)
		{
			$script ."<div class=\"pagination pagination-mini\"><ul>\n";
			$i = 0;
			$css = "";
			for($i == 0; $i <= $totallinks - 1; $i++)
			{
				if($arr[i] == $selectedpage)
				  $css = " class=\"active\"";
				else
				  $css = "";
			    $script .= "<li" . $css . "><a href=\"#\" $id=\"apg_" . $arr[$i] . "\" class=\"apagination-css\">" . $arr[$i] . "</a></li>";
			}
			$script .="</ul></div>\n";
		}
		return $script;
		
	}

    function advance_pagination_links($totalpages, $selectedpage)
    {
        $i = 0;
        $value = 0;
        $arr = array();
        $lower_arr = array();
        $upper_arr = array();
        
		$indexer = array("4","40","50","400","500","4000","5000","40000","50000");
        if ($selectedpage == 1)
        {
			// 15 links
			for($i = 1; $i <= 16; $i++)
			{
				if($i <= 7)
				  $value = $i;
				else
  				  $value = $value + $indexer[$i-8];
				if($value > $totalpages)
				   $value = $totalpages;
                if(!in_array($value,$arr))
				  $arr[] = $value;
			}
        }
		$j = 0;
        if ($selectedpage > 1)
        {
			for ($i = 1; $i <= 8; $i++)
            {				
				if($i <= 4)
				  $value = $selectedpage - $i;
				else
				{
				  $value = $value - $indexer[$i-8+(1+$j)];
				  $j++;
				}
				if($value > 0 && !in_array($value,$lower_arr))
				  $lower_arr[] = $value;
            }
            //// display upper bound
			$j = 0;
            $diff = $totalpages - $selectedpage;
			for ($i = 1; $i <= 8; $i++)
			{
				if($i <= 4)
				  $value = $selectedpage + $i;
				else
				{
					$value = $value + $indexer[$i-5];
					$j++;
				}
				if($value > $totalpages)
				  $value = $totalpages;
				if(!in_array($value,$upper_arr))
				  $upper_arr[] = $value;
			}
            //// add lower array values
            for ($i = 0; $i <= count($lower_arr) - 1; $i++)
            {
                $rev_index = (count($lower_arr) - 1) - $i;
                $arr[] = $lower_arr[$rev_index];
            }
            //// add selected record
            $arr[] = $selectedpage;
            //// add upper array values
            for ($i = 0; $i <= count($upper_arr) - 1; $i++)
            {
                $arr[] = $upper_arr[$i];
            }
        }
        return $arr;
    }
}
?>