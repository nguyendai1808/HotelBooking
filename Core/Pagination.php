<?php

class Pagination
{
    private $currentPage;
    private $totalPages;
    private $perPage;
    private $totalItems;

    public function __construct($totalItems, $perPage, $currentPage = 1)
    {
        $this->totalItems = $totalItems;
        $this->totalPages = ceil($totalItems / $perPage);
        $this->perPage = $perPage;
        $this->currentPage = $currentPage;
        $this->updateCurrentPage($currentPage);
    }

    public function getPerPage()
    {
        return $this->perPage;
    }

    public function getOffset()
    {
        return $this->perPage * ($this->currentPage - 1);
    }

    public function getTotalPages()
    {
        return $this->totalPages;;
    }

    public function getcurrentPage()
    {
        return $this->currentPage;
    }

    public function updateCurrentPage($currentPage = 1)
    {
        if (filter_var($currentPage, FILTER_VALIDATE_INT) == false || $currentPage < 1 || $currentPage > $this->totalPages) {
            $this->currentPage = 1;
        } else {
            $this->currentPage = $currentPage;
        }
    }

    //Áp dụng khi dữ liệu ít
    public function getItemsbyCurrentPage($listItems, $currentPage = 1)
    {
        if (!empty($listItems)) {
            $this->updateCurrentPage($currentPage);
            $start = ($this->currentPage - 1) * $this->perPage;
            $length = min($this->perPage, $this->totalItems - $start);
            $datas = array_slice($listItems, $start, $length);
            return $datas;
        } else {
            return null;
        }
    }
}
