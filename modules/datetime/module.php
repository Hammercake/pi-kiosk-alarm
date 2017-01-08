<?php

class Module_datetime extends Module
{
	protected $date;
	
	function render()
	{
		$this->date = $this->lang('date_format');
		
		$this->date = str_replace('[weekday]', $this->lang('weekday_' . date('N')), $this->date);
		$this->date = str_replace('[month]', $this->lang('month_' . date('n')), $this->date);
		$this->date = str_replace('[day]', date('j'), $this->date);
		$this->date = str_replace('[suffix]', date('S'), $this->date);
		
		parent::render();
	}
}