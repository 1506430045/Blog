<?php
/**
 *	PHP万年历
 */
namespace Home\Widget;
class Cale {
	private $_table;	//table表格
	private $_curDate;	//当前日期
	private $_year;		//年
	private $_month;	//月
	private $_day;		//日
	private $_days;		//给定月份的天数
	private $_dayofweek;//给定月份1号是星期几

	public function __construct() {
		$this->init();
	}

	private function init() {
		$this->table = '';
		$this->_year = date('Y');
		$this->_month = date('m'); 
		if($this->_month > 12){
			$this->_month = 1;
			$this->_year++;
		}
		if($this->_month < 1){
			$this->_month = 12;
			$this->_year--;
		}
		$this->_curDate = $this->_year.'年'.$this->_month.'月';
		$this->_days = date('t', mktime(0,0,0,$this->_month,1,$this->_year));
		$this->_dayofweek = date('w',mktime(0,0,0,$this->_month,1,$this->_year));
	}

	private function showTitle() {
		$this->_table = "<table id='blogCale' cellpadding='0' cellspacing='0' title='日历'>
							<tbody>
								<tr>
									<th><a href=''><</a></th>
									<th colspan='5'>{$this->_curDate}</th>
									<th><a href=''>></a></th>
								</tr>
							<tr>
								<th>日</th>
								<th>一</th>
								<th>二</th>
								<th>三</th>
								<th>四</th>
								<th>五</th>
								<th>六</th>
							</tr>";
	}

	private function showDate() {
		$numbers = $this->_dayofweek + 1;
		$this->_table .= '<tr>';
		for($i=1; $i <= $this->_dayofweek; $i++) {
			$this->_table .= '<td>&nbsp;</td>';
		}
		for($j=1; $j <= $this->_days; $j++) {
			if($numbers%7 == 0) {
				$this->_table .= "<td>{$j}</td></tr><tr>";
			} else {
				$this->_table .= "<td>{$j}</td>";
			}
			$numbers++;
		}
		$this->_table .= '</tr></tbody></table>';
	}
	public function show() {
		$this->showTitle();
		$this->showDate();
		return $this->_table;
	}
}





















