<?php

namespace app\queue\redis;

use PhpOffice\PhpSpreadsheet\Reader\IReadFilter;

class ChunkReadFilter implements IReadFilter
{
    private int $_startRow = 0;

    private int $_endRow = 0;
    private mixed $_columns = [];


    /**  We expect a list of the rows that we want to read to be passed into the constructor  */
    public function __construct($startRow, $chunkSize, $columns = []) {
        $this->_startRow	= $startRow;
        $this->_endRow		= $startRow + $chunkSize;
        //默认读取A~AZ 52列
        $def_columns = range('A','Z');
        $this->_columns = [];
        foreach ($def_columns as $ival){
            $this->_columns[] = $ival;
            foreach ($def_columns as  $val){
                $this->_columns[] = $ival."".$val;
            }
        }
        $this->_columns = array_merge($this->_columns, $def_columns);
        if (count($columns) > 0) {
            $this->_columns		= $columns;
        }
    }

    public function readCell($columnAddress, $row, $worksheetName = ''): bool
    {
        //  Only read the heading row, and the rows that were configured in the constructor
        if (($row == 1) || ($row >= $this->_startRow && $row < $this->_endRow)) {
            if (in_array($columnAddress,$this->_columns)) {
                return true;
            }
        }
        return false;
    }
}