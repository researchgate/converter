<?php
/*
Released through http://bibliophile.sourceforge.net under the GPL licence.
Do whatever you like with this -- some credit to the author(s) would be appreciated.

A collection of PHP classes to manipulate bibtex files.

If you make improvements, please consider contacting the administrators at bibliophile.sourceforge.net 
so that your improvements can be added to the release package.

Mark Grimshaw 2005
http://bibliophile.sourceforge.net*/
/*****
*	PARSEPAGE: BibTeX PAGES import class
*****/
class PARSEPAGE
{
// Constructor
	public function __construct()
	{
	}
// Create page arrays from bibtex input.
// 'pages' field can be:
//	"77--99"
//	"3 - 5"
//	"ix -- 101"
//	"73+"
//	73, 89,103"
// Currently, PARSEPAGE will take 1/, 2/ and 3/ above as page_start and page_end and, in the other cases, will accept
// the first valid number it finds from the left as page_start setting page_end to NULL
	public function init($item)
	{
		$item = trim($item);
		if($this->type1($item))
			return $this->return;
// else, return first number we can find
		if(preg_match("/(\d+|[ivx]+)/i", $item, $array))
			return [$array[1], FALSE];
// No valid page numbers found
		return [FALSE, FALSE];;
	}
// "77--99" or '-'type?
	public function type1($item)
	{
		$start = $end = FALSE;
		$array = preg_split("/--|-/", $item);
		if(sizeof($array) > 1)
		{
			if(is_numeric(trim($array[0])))
				$start = trim($array[0]);
			else
				$start = strtolower(trim($array[0]));
			if(is_numeric(trim($array[1])))
				$end = trim($array[1]);
			else
				$end = strtolower(trim($array[1]));
			if($end && !$start)
				$this->return = [$end, $start];
			else
				$this->return = [$start, $end];
			return TRUE;
		}
		return FALSE;
	}
}
?>
