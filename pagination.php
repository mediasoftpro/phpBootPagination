<?php
require_once "logic.php";
    
class bootPagination
{
	public $pagenumber;
    public $pagesize;
    public $totalrecords;
    public $showfirst;
    public $showlast;
	public $paginationcss;
	public $paginationstyle;
	
	public $defaultUrl;
	public $paginationUrl;
	
	function __construct()
	{
		$this->pagenumber = 1;
		$this->pagesize = 20;
		$this->totalrecords = 0;
		$this->showfirst = true;
		$this->showlast = true;
		$this->paginationcss = "pagination-small";
		$this->paginationstyle = 1;  // 1: advance, 0: normal
		
		$this->defaultUrl = "#"; // in case of ajax pagination
		$this->paginationUrl = "#"; // # incase of ajax pagination e.g index.php?p=[p] --> 
	}
	
	function process()
	{		
	    $paginationlst = "";
		$firstbound =0;
		$lastbound =0;
		$tooltip = "";
		
		if($this->totalrecords > $this->pagesize)
	    {
		     $totalpages = ceil($this->totalrecords / $this->pagesize);
   
			if ($this->pagenumber > 1)
			{
			   if ($this->showfirst)
			   {
				   $firstbound = 1;
				   $lastbound = $firstbound + $this->pagesize - 1;
				   $tooltip = "showing " . $firstbound . " - " . $lastbound . " records of " . $this->totalrecords . " records";
				   // First Link
				   if($this->defaultUrl == "")
				      $this->defaultUrl = "#";
				   $paginationlst .= "<li><a id=\"p_1\" href=\"" . $this->defaultUrl . "\" class=\"pagination-css\" data-toggle=\"tooltip\" title=\"" . $tooltip . "\"><i class=\"glyphicon glyphicon-backward\"></i></a></li>\n";
				}
				$firstbound = (($totalpages - 1) * $this->pagesize);
				$lastbound = $firstbound + $this->pagesize - 1;
				if ($lastbound > $this->totalrecords)
				{
					$lastbound = $this->totalrecords;
				}
				$tooltip = "showing " . $firstbound . " - " . $lastbound . " records of " . $this->totalrecords . " records";
				// Previous Link Enabled
				if($this->paginationUrl == "")
				  $this->paginationUrl = "#";
				
				$pid = ($this->pagenumber - 1);
				if($pid < 1)  $pid = 1;
				$paginationlst .= "<li><a id=\"pp_" . $pid . "\" href=\"" . $this->prepareUrl($pid) . "\" data-toggle=\"tooltip\" class=\"pagination-css\" title=\"" . $tooltip . "\"><i class=\"glyphicon glyphicon-chevron-left\"></i></a></li>\n";
				// Normal Links
				$paginationlst .= $this->generate_pagination_links($totalpages, $this->totalrecords, $this->pagenumber, $this->pagesize);
			   
				if($this->pagenumber < $totalpages)
				{
					 $paginationlst .= $this->generate_previous_last_links($totalpages, $this->totalrecords, $this->pagenumber, $this->pagesize, $this->showlast);
				}
			}
			else
			{
				// Normal Links
				$paginationlst .= $this->generate_pagination_links($totalpages, $this->totalrecords, $this->pagenumber, $this->pagesize);
				// Next Last Links
				$paginationlst .= $this->generate_previous_last_links($totalpages, $this->totalrecords, $this->pagenumber, $this->pagesize, $this->showlast);
			}
		}
		return "<ul class=\"pagination " . $this->paginationcss . "\">\n" . $paginationlst . "</ul>\n";
	}
	
    function generate_pagination_links($totalpages, $totalrecords, $pagenumber, $pagesize)
    {
        $script = "";
        $firstbound = 0;
        $lastbound = 0;
        $tooltip = "";

        $lst = new pagination();
		if($this->paginationstyle == 1)
		   $arr = $lst->advance_pagination_links($totalpages, $pagenumber);
		else
		   $arr = $lst->simple_pagination_links($totalpages, 15, $pagenumber);
		if(count($arr) > 0)
	    {
		   foreach ($arr as $item){
			   $firstbound = (($item - 1) * $pagesize) + 1;
			   $lastbound = $firstbound + $pagesize - 1;
                if ($lastbound > $totalrecords)
                    $lastbound = $totalrecords;
                $tooltip = "showing " . $firstbound . " - " . $lastbound . " records  of " . $totalrecords . " records";
                $css = "";
                if ($item == $pagenumber)
                    $css = " class=\"active\"";
                $script .= "<li" . $css . "><a id=\"pg_" . $item . "\" href=\"" . $this->prepareUrl($item) . "\" class=\"pagination-css\" data-toggle=\"tooltip\" title=\"" . $tooltip . "\">" . $item . "</a></li>\n";
	       }
	   }
       return $script;
    }

    function generate_previous_last_links($totalpages, $totalrecords, $pagenumber, $pagesize, $showlast)
    {
        $script = "";
        $firstbound = (($pagenumber) * $pagesize) + 1;
        $lastbound = $firstbound + $pagesize - 1;
        if ($lastbound > $totalrecords)
            $lastbound = $totalrecords;

        $tooltip = "showing " . $firstbound . " - " . $lastbound . " records of " . $totalrecords . " records";
        // Next Link
		$pid = ($pagenumber + 1);
		if($pid > $totalpages) $pid = $totalpages;
        $script .= "<li><a id=\"pn_" . $pid . "\" href=\"" . $this->prepareUrl($pid) . "\" class=\"pagination-css\" data-toggle=\"tooltip\" title=\"" . $tooltip . "\"><i class=\"glyphicon glyphglyphicon glyphicon-chevron-right\"></i></a></li>\n";
        if ($showlast)
        {
            // Last Link
            $firstbound = (($totalpages - 1) * $pagesize) + 1;
            $lastbound = $firstbound + $pagesize - 1;
            if ($lastbound > $totalpages)
                $lastbound = $totalpages;
            $tooltip = "showing " . $firstbound . " - " . $lastbound . " records of " . $totalrecords . " records";
            $script .= "<li><a id=\"pl_" . $totalpages . "\" href=\"" . $this->prepareUrl($totalpages) . "\" class=\"pagination-css\" data-toggle=\"tooltip\" title=\"" . $tooltip . "\"><i class=\"glyphicon glyphicon-forward\"></i></a></li>\n";
        }
        return $script;

    }
	
	function prepareUrl($pid)
	{
		if($this->paginationUrl == "")
		  $this->paginationUrl = "#";
		if($pid > 1)
		  return preg_replace("/\[p\]/", $pid, $this->paginationUrl);
		else
		  return preg_replace("/\[p\]/", $pid, $this->defaultUrl);
	}
}
?>
