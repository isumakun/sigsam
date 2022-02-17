<?php
require 'app/third_party/pdf/fpdf.php';

class PDF extends FPDF
{
	function get_width($width)
	{
		$min_width = 8.65;
		$inner_spaces = (($width / 5) - 1) * 1.2;
		return ($width / 5) * $min_width + $inner_spaces;
	}

	function add_title($text)
	{
		$this->y += 2;
		$this->SetTextColor(255);
		$this->SetFont('helvetica', 'B', 8);

		//$this->SetFillColor(231,76,60);
		$this->SetFillColor(36,71,94);
		$this->Rect($this->x, $this->y, 196, 4, 'F');

		$this->Text($this->x + 1, $this->y + 3, utf8_decode($text));

		$this->x = 10;
		$this->y += 5;
	}

	function add_subtitle($text)
	{
		$this->SetTextColor(255);
		$this->SetFont('helvetica', 'B', 8);

		//$this->SetFillColor(155,89,182);
		$this->SetFillColor(65,85,98);
		$this->Rect($this->x, $this->y, 196, 4, 'F');

		$this->Text($this->x + 1, $this->y + 3, utf8_decode($text));

		$this->x = 10;
		$this->y += 5;
	}

	function add_row($fields, $align = 'L')
	{
		$max_height = 0;
		foreach ($fields AS $f)
		{
			$field = $f[1];

			$height = $this->GetStringWidth($field) / $this->get_width($f[2]);
			if ($max_height < $height)
			{
				$max_height = $height;
			}
		}

		if ($this->y + $max_height >= 256)
		{
			$this->AddPage();
		}

		$max_y = 0;
		$original_y = $this->y;

		$i = 0;
		foreach ($fields AS $f)
		{
			$label = $f[0];
			$field = $f[1];

			if (!$f[3]) $f[3] = 'L';

			$width = $this->get_width($f[2]);

			$current_x = $this->x;

			$this->SetFillColor(250);
			$this->Rect($this->x, $this->y, $width, 4, 'F');

			$this->SetTextColor(50);
			$this->SetFont('helvetica', 'B', 7);
			$this->Text($this->x + 1, $this->y + 3, utf8_decode($label));

			$this->y += 5;
			$this->x += 1;

			$this->SetTextColor(80);
			$this->SetFont('helvetica', '', 7);
			$this->MultiCell($width - 2, 3, utf8_decode($field), 0, $f[3]);

			if ($this->GetY() > $max_y) $max_y = $this->GetY();

			$this->x = $current_x + $width + 1.2;
			$this->y = $original_y;

			$draw_fields[$i]['x'] = $current_x;
			$draw_fields[$i]['y'] = $this->y;
			$draw_fields[$i]['w'] = $width;

			$i++;
		}

		foreach ($draw_fields AS $df)
		{
			$this->SetDrawColor(210);
			$this->Rect($df['x'], $df['y'], $df['w'], $max_y - $this->y + 1);
		}

		$this->y = $max_y + 2.1;
		$this->x = 10;
	}

	function add_collapse_row($fields)
	{
		$this->SetFont('helvetica', '', 7);

		$max_height = 0;
		foreach ($fields AS $f)
		{
			$field = $f[1];

			$height = $this->GetStringWidth($field) / $this->get_width($f[2]);
			if ($max_height < $height)
			{
				$max_height = $height;
			}
		}

		if ($this->y + $max_height >= 267.4)
		{
			$this->AddPage();
		}

		$this->y -= 1.2;

		$max_y = 0;
		$original_y = $this->y;

		$i = 0;
		foreach ($fields AS $f)
		{
			$label = $f[0];
			$field = $f[1];

			if (!$f[3]) $f[3] = 'L';

			$width = $this->get_width($f[2]);

			$current_x = $this->x;

			$this->y += 1.2;
			$this->x += 1;

			$this->MultiCell($width - 2, 3, utf8_decode($field), 0, $f[3]);

			if ($this->GetY() > $max_y) $max_y = $this->GetY();

			$this->x = $current_x + $width + 1.2;
			$this->y = $original_y;

			$draw_fields[$i]['x'] = $current_x;
			$draw_fields[$i]['y'] = $this->y;
			$draw_fields[$i]['w'] = $width;

			$i++;
		}

		foreach ($draw_fields AS $df)
		{
			$this->SetDrawColor(210);
			$this->Rect($df['x'], $df['y'], $df['w'], $max_y - $this->y + 1);
		}

		$this->y = $max_y + 2.1;
		$this->x = 10;
	}
}
