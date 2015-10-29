<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class calendario_pymes extends CI_Calendar {
	function generate($year = '', $month = '', $data = array())
	{

		// Set and validate the supplied month/year
		if ($year == '')
			$year  = date("Y", $this->local_time);

		if ($month == '')
			$month = date("m", $this->local_time);

		if (strlen($year) == 1)
			$year = '200'.$year;

		if (strlen($year) == 2)
			$year = '20'.$year;

		if (strlen($month) == 1)
			$month = '0'.$month;

		$adjusted_date = $this->adjust_date($month, $year);

		$month	= $adjusted_date['month'];
		$year	= $adjusted_date['year'];

		// Determine the total days in the month
		$total_days = $this->get_total_days($month, $year);

		// Set the starting day of the week
		$start_days	= array('sunday' => 0, 'monday' => 1, 'tuesday' => 2, 'wednesday' => 3, 'thursday' => 4, 'friday' => 5, 'saturday' => 6);
		$start_day = ( ! isset($start_days[$this->start_day])) ? 0 : $start_days[$this->start_day];

		// Set the starting day number
		$local_date = mktime(12, 0, 0, $month, 1, $year);
		$date = getdate($local_date);
		$day  = $start_day + 1 - $date["wday"];

		while ($day > 1)
		{
			$day -= 7;
		}

		// Set the current month/year/day
		// We use this to determine the "today" date
		$cur_year	= date("Y", $this->local_time);
		$cur_month	= date("m", $this->local_time);
		$cur_day	= date("j", $this->local_time);

		$is_current_month = ($cur_year == $year AND $cur_month == $month) ? TRUE : FALSE;

		// Generate the template data array
		$this->parse_template();

		// Begin building the calendar output
		$out = $this->temp['table_open'];
		$out .= "\n";

		$out .= "\n";
		$out .= $this->temp['heading_row_start'];
		$out .= "\n";

		// "previous" month link
		if ($this->show_next_prev == TRUE)
		{
			// Add a trailing slash to the  URL if needed
			$this->next_prev_url = preg_replace("/(.+?)\/*$/", "\\1/",  $this->next_prev_url);

			$adjusted_date = $this->adjust_date($month - 1, $year);
			$out .= str_replace('{previous_url}', $this->next_prev_url.$adjusted_date['year'].'/'.$adjusted_date['month'], $this->temp['heading_previous_cell']);
			$out .= "\n";
		}

		// Heading containing the month/year
		$colspan = ($this->show_next_prev == TRUE) ? 5 : 7;

		$this->temp['heading_title_cell'] = str_replace('{colspan}', $colspan, $this->temp['heading_title_cell']);
		$this->temp['heading_title_cell'] = str_replace('{heading}', $this->get_month_name($month)."&nbsp;".$year, $this->temp['heading_title_cell']);

		$out .= $this->temp['heading_title_cell'];
		$out .= "\n";

		// "next" month link
		if ($this->show_next_prev == TRUE)
		{
			$adjusted_date = $this->adjust_date($month + 1, $year);
			$out .= str_replace('{next_url}', $this->next_prev_url.$adjusted_date['year'].'/'.$adjusted_date['month'], $this->temp['heading_next_cell']);
		}

		$out .= "\n";
		$out .= $this->temp['heading_row_end'];
		$out .= "\n";

		// Write the cells containing the days of the week
		$out .= "\n";
		$out .= $this->temp['week_row_start'];
		$out .= "\n";

		$day_names = $this->get_day_names();

		for ($i = 0; $i < 7; $i ++)
		{
			$out .= str_replace('{week_day}', $day_names[($start_day + $i) %7], $this->temp['week_day_cell']);
		}

		$out .= "\n";
		$out .= $this->temp['week_row_end'];
		$out .= "\n";

		$event_count = 0;

		// Build the main body of the calendar
		while ($day <= $total_days)
		{
			$out .= "\n";
			$out .= $this->temp['cal_row_start'];
			$out .= "\n";

			for ($i = 0; $i < 7; $i++)
			{
				$out .= ($is_current_month == TRUE AND $day == $cur_day) ? $this->temp['cal_cell_start_today'] : $this->temp['cal_cell_start'];

				if ($day > 0 AND $day <= $total_days)
				{
					if (isset($data[$day]))
					{
						// Cells with content
						$temp = ($is_current_month == TRUE AND $day == $cur_day) ? $this->temp['cal_cell_content_today'] : $this->temp['cal_cell_content'];
						
						// Mode than one event the same day
						if(is_array($data[$day]))
						{
							$several_events = '';
							foreach($data[$day] as $key => $value)
							{
								$e_data = $data['events'][$value];
								$e_period = $e_data['end']-$e_data['start']+1;
								$w_period = 7-$i;

								if($e_period > $w_period)
								{
									// add event for next week
									$new_event = $e_data;
									$new_event['start'] = $e_data['start']+$w_period;
									$data['events'][] = $new_event;
									$data[$new_event['start']][] = count($data['events'])-1;

									// stop this event this week
									$e_data['end'] = $e_data['start']+$w_period-1;
								}
								$e_period = $e_data['end']-$e_data['start']+1;

								// Texto para el periodo del evento
								$dias = array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
								$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
								if($e_data['event_start'] == $e_data['event_end'])
									$periodo_str = '<i>'.$dias[date('w', strtotime($e_data['event_start']))]." ".date('d', strtotime($e_data['event_start']))." de ".$meses[date('n', strtotime($e_data['event_start']))-1].'</i>';
								else
								{
									$same_year = date('Y', strtotime($e_data['event_start'])) == date('Y', strtotime($e_data['event_end']));
									$periodo_str = $dias[date('w', strtotime($e_data['event_start']))]." ".date('d', strtotime($e_data['event_start']))." de ".$meses[date('n', strtotime($e_data['event_start']))-1].(!$same_year ? ' del '.date('Y', strtotime($e_data['event_start'])) : '').
										' al '.$dias[date('w', strtotime($e_data['event_end']))]." ".date('d', strtotime($e_data['event_end']))." de ".$meses[date('n', strtotime($e_data['event_end']))-1].(!$same_year ? ' del '.date('Y', strtotime($e_data['event_end'])) : '');
								}
								
								// Texto para las regiones del evento
								$r_nombre = '';
                                if(count($e_data['regiones']) != count($data['regiones']))
                                {
	                                foreach($e_data['regiones'] as $k => $r)
	                                    $r_nombre .= ($k == 0 ? '':', ').$r->nombre;
	                            }
	                            else
	                            	$r_nombre = 'Todas las Regiones';

	                            // Output para cada evento en cada semana
								$several_events .= '
									<div id="pop'.$event_count.'" class="popbox '.($e_data['expiro'] ? 'expirado' : '').'" style="">'.
										($e_data['expiro'] ? '<span class="msg_expirado">Finalizado</span>' : '')
										.'<h2>'.$e_data['titulo'].'</h2>
										<ul>
											<li><span style="font-size: small; font-weight: bold;">Región donde se realiza: </span><span>'.$r_nombre.'</span></li>
											<li><span style="font-size: small; font-weight: bold;">Duración: </span><span>'.$periodo_str.'</span></li>
											<li><span style="font-size: small; font-weight: bold;">Institución que realiza la actividad: </span><span>'.$e_data['institucion'].'</span></li>
											'.(strlen($e_data['info']) > 0 ? ('<li><span style="font-size: small; font-weight: bold;">Más Información: </span><span><br/>'.$e_data['info'].'</span></li>') : '').'
										</ul>
									</div>
									<a href="'.$e_data['url'].'" target="_blank" bgcol="'.$e_data['bgcolor'].'" class="popper" data-popbox="pop'.$event_count.'">
										<div class="cal_item" data-row="'.$key.'" data-col="'.$e_period.'">'.$e_data['titulo'].'</div>
									</a>
									'."\n";
								$event_count++;
							}
							$out .= str_replace('{day}', ($day < 10) ? "0$day" : $day, str_replace('{content}', $several_events, $temp));
						}
						// One event per day --> INFO: No deberian llegar la variable sin ser Array
						else
						{
							$out .= str_replace('{day}', $day, str_replace('{content}', $data[$day], $temp));
						}
					}
					else
					{
						// Cells with no content
						$temp = ($is_current_month == TRUE AND $day == $cur_day) ? $this->temp['cal_cell_no_content_today'] : $this->temp['cal_cell_no_content'];
						$out .= str_replace('{day}', ($day < 10) ? "0$day" : $day, $temp);
					}
				}
				else
				{
					// Blank cells
					$out .= $this->temp['cal_cell_blank'];
				}

				$out .= '<div id="todos-'.$day.'" style="display: none;"><br /><br /></div>';
				$out .= '<div class="ver-todos"><a href="" data-modal-type="div" data-modal-id="todos-'.$day.'" data-toggle="modal-chileatiende"  data-ga-te-category="Acciones Ficha" data-ga-te-action="" data-ga-te-value="">Ver todos</a></div>';


				$out .= ($is_current_month == TRUE AND $day == $cur_day) ? $this->temp['cal_cell_end_today'] : $this->temp['cal_cell_end'];					
				$day++;
			}

			$out .= "\n";
			$out .= $this->temp['cal_row_end'];
			$out .= "\n";
		}

		$out .= "\n";
		$out .= $this->temp['table_close'];

		return $out;
	}
}

?>