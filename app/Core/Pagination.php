<?php

class Pagination
{
    private $listItems;
    private $perPage;
    private $currentPage;
    private $totalPages;
    private $totalItems;


    public function __construct($listItems, $perPage)
    {
        $this->listItems = $listItems;
        $this->totalItems = count($listItems);
        $this->perPage = $perPage;
        $this->totalPages = ceil($this->totalItems / $this->perPage);
        $this->currentPage = 1;
    }

    public function getTotalPages()
    {
        return $this->totalPages;;
    }

    public function getcurrentPage()
    {
        return $this->currentPage;
    }

    public function getAllItems()
    {
        return $this->listItems;
    }

    public function getItemsbyCurrentPage($currentPage = 1)
    {
        if ($currentPage < 1 ||  $currentPage > $this->totalPages) {
            $this->currentPage = 1;
        } else {
            $this->currentPage = $currentPage;
        }
        $start = ($this->currentPage - 1) * $this->perPage;
        $end = min($start + $this->perPage, $this->totalItems);
        $datas = array_slice($this->listItems, $start, $end - $start);
        return $datas;
    }
}
