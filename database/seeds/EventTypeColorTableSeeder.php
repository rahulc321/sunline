<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EventTypeColor;

class EventTypeColorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
		EventTypeColor::create([
			'title' => 'Legal CRM Blue',
			'color_code' => '#012169',
		]);
		EventTypeColor::create([
			'title' => 'Outlook Calendar: Red',
			'color_code' => '#E74856',
		]);
		EventTypeColor::create([
			'title' => 'Outlook Calendar: Orange',
			'color_code' => '#FF8C00',
		]);
		EventTypeColor::create([
			'title' => 'Outlook Calendar: Peach',
			'color_code' => '#FFAB45',
		]);
		EventTypeColor::create([
			'title' => 'Outlook Calendar: Yellow',
			'color_code' => '#FFF100',
		]);
		EventTypeColor::create([
			'title' => 'Outlook Calendar: Green',
			'color_code' => '#47D041',
		]);
		EventTypeColor::create([
			'title' => 'Outlook Calendar: Light teal',
			'color_code' => '#30C6CC',
		]);
		EventTypeColor::create([
			'title' => 'Outlook Calendar: Olive',
			'color_code' => '#73AA24',
		]);
		EventTypeColor::create([
			'title' => 'Outlook Calendar: Blue',
			'color_code' => '#00BCF2',
		]);
		EventTypeColor::create([
			'title' => 'Outlook Calendar: Purple',
			'color_code' => '#8764B8',
		]);
		EventTypeColor::create([
			'title' => 'Outlook Calendar: Pink',
			'color_code' => '#F495BF',
		]);
		EventTypeColor::create([
			'title' => 'Outlook Calendar: Steel light',
			'color_code' => '#A0AEB2',
		]);
		EventTypeColor::create([
			'title' => 'Outlook Calendar: Steel gray',
			'color_code' => '#004B60',
		]);
		EventTypeColor::create([
			'title' => 'Outlook Calendar: Light gray',
			'color_code' => '#B1ADAB',
		]);
		EventTypeColor::create([
			'title' => 'Outlook Calendar: Gray',
			'color_code' => '#5D5A58',
		]);
		EventTypeColor::create([
			'title' => 'Outlook Calendar: Black',
			'color_code' => '#000000',
		]);
		EventTypeColor::create([
			'title' => 'Outlook Calendar: Dark red',
			'color_code' => '#750B1C',
		]);
		EventTypeColor::create([
			'title' => 'Outlook Calendar: Dark orange',
			'color_code' => '#CA5010',
		]);
		EventTypeColor::create([
			'title' => 'Outlook Calendar: Brown',
			'color_code' => '#AB620D',
		]);
		EventTypeColor::create([
			'title' => 'Outlook Calendar: Dark yellow',
			'color_code' => '#C19C00',
		]);
		EventTypeColor::create([
			'title' => 'Outlook Calendar: Dark green',
			'color_code' => '#004B1C',
		]);
		EventTypeColor::create([
			'title' => 'Outlook Calendar: Dark teal',
			'color_code' => '#004B50',
		]);
		EventTypeColor::create([
			'title' => 'Outlook Calendar: Dark olive',
			'color_code' => '#0B6A0B',
		]);EventTypeColor::create([
			'title' => 'Outlook Calendar: Dark blue',
			'color_code' => '#002050',
		]);
		EventTypeColor::create([
			'title' => 'Outlook Calendar: Dark purple',
			'color_code' => '#32145A',
		]);
		EventTypeColor::create([
			'title' => 'Outlook Calendar: Dark magenta',
			'color_code' => '#5C005C',
		]);
		EventTypeColor::create([
			'title' => 'Google Calendar: Tomato',
			'color_code' => '#D50000',
		]);
		EventTypeColor::create([
			'title' => 'Google Calendar: Flamingo',
			'color_code' => '#E67C73',
		]);
		EventTypeColor::create([
			'title' => 'Google Calendar: Tangerine',
			'color_code' => '#F4511E',
		]);
		EventTypeColor::create([
			'title' => 'Google Calendar: Banana',
			'color_code' => '#F6BF26',
		]);
		EventTypeColor::create([
			'title' => 'Google Calendar: Sage',
			'color_code' => '#33B679',
		]);
		EventTypeColor::create([
			'title' => 'Google Calendar: Basil',
			'color_code' => '#0B8043',
		]);
		EventTypeColor::create([
			'title' => 'Google Calendar: Peacock',
			'color_code' => '#039BE5',
		]);
		EventTypeColor::create([
			'title' => 'Google Calendar: Blueberry',
			'color_code' => '#3F51B5',
		]);
		EventTypeColor::create([
			'title' => 'Google Calendar: Lavender',
			'color_code' => '#7986CB',
		]);
		EventTypeColor::create([
			'title' => 'Google Calendar: Grape',
			'color_code' => '#8E24AA',
		]);
		EventTypeColor::create([
			'title' => 'Google Calendar: Graphite',
			'color_code' => '#616161',
		]);
		
    }
}
