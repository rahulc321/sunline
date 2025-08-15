<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\IntakeValues;

class IntakeValuesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $intake_values = json_decode('[
			{"id":"57","type":"marketing_source","value":"DLM-Dia-mva"},
			{"id":"58","type":"marketing_source","value":"(800) 810-1757 MAIN TV NUMBER"},
			{"id":"59","type":"marketing_source","value":"Ari Sibrey - Referrals"},
			{"id":"60","type":"marketing_source","value":"Attorney Referral"},
			{"id":"61","type":"marketing_source","value":"Birthday Cards"},
			{"id":"62","type":"marketing_source","value":"Call In"},
			{"id":"63","type":"marketing_source","value":"CD Lead Call Back Number"},
			{"id":"64","type":"marketing_source","value":"CD-PPC-NC-Form Submission"},
			{"id":"65","type":"marketing_source","value":"CD-PPC-NC-Phone Call"},
			{"id":"66","type":"marketing_source","value":"CD-PPC-SC-Form Submission"},
			{"id":"67","type":"marketing_source","value":"CD-PPC-SC-Phone Call"},
			{"id":"68","type":"marketing_source","value":"CD-PPC-VA-Form Submission"},
			{"id":"69","type":"marketing_source","value":"CD-PPC-VA-Phone Call"},
			{"id":"70","type":"marketing_source","value":"Clauson Disability Main Website - Form Submission"},
			{"id":"71","type":"marketing_source","value":"Clauson Disability Main Website - Phone Call"},
			{"id":"72","type":"marketing_source","value":"Clauson Law - New TV (ACT) - MVA"},
			{"id":"73","type":"marketing_source","value":"Clauson Law - New TV (ACT) - SSD"},
			{"id":"74","type":"marketing_source","value":"Clauson Law - New TV (ACT) - VA Disability"},
			{"id":"75","type":"marketing_source","value":"Clauson Law PPC"},
			{"id":"76","type":"marketing_source","value":"Clausonlaw website www.clausonlaw.com"},
			{"id":"77","type":"marketing_source","value":"clausonlaw.com"},
			{"id":"78","type":"marketing_source","value":"CLF LR Inbound Calls"},
			{"id":"79","type":"marketing_source","value":"CLF Main Website - Form Submission"},
			{"id":"80","type":"marketing_source","value":"CLF Main Website - Phone Call"},
			{"id":"81","type":"marketing_source","value":"Client Referral"},
			{"id":"82","type":"marketing_source","value":"DHT Unbranded PPC"},
			{"id":"83","type":"marketing_source","value":"DHT Unbranded PPC - Form Submission"},
			{"id":"84","type":"marketing_source","value":"DIHT-TV-Zantac"},
			{"id":"85","type":"marketing_source","value":"Disability Attorneys"},
			{"id":"86","type":"marketing_source","value":"DL Marketing"},
			{"id":"87","type":"marketing_source","value":"DL Marketing - LO"},
			{"id":"88","type":"marketing_source","value":"DL Marketing - EQ"},
			{"id":"89","type":"marketing_source","value":"DL Marketing - LL"},
			{"id":"90","type":"marketing_source","value":"DL Marketing - PP"},
			{"id":"91","type":"marketing_source","value":"DLM -VG-TALC"},
			{"id":"92","type":"marketing_source","value":"DLM- LO47"},
			{"id":"93","type":"marketing_source","value":"DLM-AM-MVA"},
			{"id":"94","type":"marketing_source","value":"DLM-Dia-ssd"},
			{"id":"95","type":"marketing_source","value":"DLM-GO-ssd"},
			{"id":"96","type":"marketing_source","value":"DLM-GSSDLIVE"},
			{"id":"97","type":"marketing_source","value":"DLM-Live-DMM-CALL"},
			{"id":"98","type":"marketing_source","value":"DLM-LiveAutoCall-PP"},
			{"id":"99","type":"marketing_source","value":"DLM-LO-Live Call Leads"},
			{"id":"100","type":"marketing_source","value":"DLM-LO-MVA"},
			{"id":"101","type":"marketing_source","value":"DLM-LO-SSD-Incomplete"},
			{"id":"102","type":"marketing_source","value":"DLM-LO-SSD-SSIonly"},
			{"id":"103","type":"marketing_source","value":"DLM-LO-SSD-Under50"},
			{"id":"104","type":"marketing_source","value":"DLM-LO50"},
			{"id":"105","type":"marketing_source","value":"DLM-LO55"},
			{"id":"106","type":"marketing_source","value":"DLM-MEE-Live Call Leads"},
			{"id":"107","type":"marketing_source","value":"Clauson Law Firm – Social Security Disability Lawyers North Carolina"},
			{"id":"108","type":"marketing_source","value":"Clauson Law Firm in North Carolina represents Social Security disability (SSD) clients"},
			{"id":"109","type":"marketing_source","value":"Supplemental Security Income"},
			{"id":"110","type":"marketing_source","value":"Social Security Disability Insurance"},
			{"id":"113","type":"ad_campaign","value":"None"},
			{"id":"114","type":"office_location","value":"None"},
			{"id":"115","type":"attorney","value":"None"}
		]',true);

        IntakeValues::insert($intake_values);
    }
}
