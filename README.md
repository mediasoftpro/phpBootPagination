Bootstrap 3.0 Compatible Advance Pagination Script for PHP
=================================

phpBootPagination script help you implement complex pagination links easily just by writing few lines of code. It has full compatibity with bootstrap 3.0

List of main features include

i: support both simple and advance paginations

ii: bootstrap 3.0 compatible pagination links

iii: support jquery pagination.

Sample Usage Example
==================================

// test values
<pre>
$pagenumber = 57;
$totalrecords = 45533;
</pre>
<pre>
include_once("pagination.php"); 
$pg = new bootPagination();
$pg->pagenumber = $pagenumber;
$pg->pagesize = $pagesize;
$pg->totalrecords = $totalrecords;
$pg->showfirst = true;
$pg->showlast = true;
$pg->paginationcss = "pagination-large";
$pg->paginationstyle = 1; // 1: advance, 0: normal
$pg->defaultUrl = "index.php";
$pg->paginationUrl = "index.php?p=[p];
echo $apagination->process();
</pre>

For more detail and documentation visit

http://www.mediasoftpro.com/php/bootpagination/
