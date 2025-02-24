<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Designation;
use App\Models\Department;
use App\Models\Division;
use App\Models\Branch;
use App\Models\Location;
use App\Models\Segment;
use App\Models\Vertical;
use App\Models\Model;
use App\Models\UserReporting;
use Illuminate\Support\Facades\Hash;

class UserbaseSeeder extends Seeder
{
    public function run()
    {
        // Seed Designations
        $designations = [
            'DP',
            'CEO',
            'CX Manager',
            'Dy. General Manager',
            'General Manager',
            'Team Leader',
            'Showroom Sales Consultant',
            'Sales Consultant',
            'Sales Manager'
        ];
        $designationIds = [];
        foreach ($designations as $name) {
            $designationIds[$name] = Designation::create(['name' => $name, 'slug' => slug_format($name)])->id;
        }

        // Seed Departments
        $departments = ['Sales'];
        $departmentIds = [];
        foreach ($departments as $name) {
            $departmentIds[$name] = Department::create(['name' => $name, 'slug' => slug_format($name)])->id;
        }

        // Seed Divisions (Inferred)
        $divisions = [
            ['department_id' => $departmentIds['Sales'], 'name' => 'New Vehicle Sales', 'slug' => 'new-vehicle-sales'],
            ['department_id' => $departmentIds['Sales'], 'name' => 'Used Vehicle Sales', 'slug' => 'used-vehicle-sales'],
        ];
        $divisionIds = [];
        foreach ($divisions as $data) {
            $divisionIds[$data['name']] = Division::create($data)->id;
        }

        // Seed Branches
        $branches = ['Bikaner', 'Churu'];
        $branchIds = [];
        foreach ($branches as $name) {
            $branchIds[$name] = Branch::create(['name' => $name, 'slug' => slug_format($name)])->id;
        }

        // Seed Locations
        $locations = [
            'Bikaner' => ['Bikaner', 'Nokha', 'Sujagarh', 'Sri Dungargarh', 'Napasar', 'Lunkaransar', 'Chhatargarh', 'Khajuwala', 'Kolayat'],
            'Churu' => ['Churu', 'Rajgarh', 'Sardarshahar', 'Ratangarh', 'Bhanipura', 'Sidmukkh', 'Taranagar'],
        ];
        $locationIds = [];
        foreach ($locations as $branch => $locs) {
            foreach ($locs as $name) {
                $locationIds[$name] = Location::create([
                    'branch_id' => $branchIds[$branch],
                    'name' => $name,
                    'slug' => slug_format($name)
                ])->id;
            }
        }

        // Seed Segments
        $segments = ['Personal', 'Commercial', 'LMM'];
        $segmentIds = [];
        foreach ($segments as $name) {
            $segmentIds[$name] = Segment::create(['name' => $name, 'slug' => slug_format($name)])->id;
        }

        // Seed Verticals
        $verticals = ['New Vehicle', 'Used Vehicle'];
        $verticalIds = [];
        foreach ($verticals as $name) {
            $verticalIds[$name] = Vertical::create(['name' => $name, 'slug' => slug_format($name)])->id;
        }

        // Seed Models (Expanded from earlier data)
        $models = [
            'Bolero',
            'Scorpio',
            'Thar',
            'XUV3XO',
            'XUV400',
            'XUV700',
            'Thar Roxx'
        ];
        $modelIds = [];
        foreach ($models as $name) {
            $modelIds[$name] = Model::create([
                'segment_id' => $segmentIds['Personal'], // Default to Personal; adjust as needed
                'name' => $name,
                'slug' => slug_format($name)
            ])->id;
        }

        // Seed Users
        $usersData = [
            ['name' => 'Niranjan Gupta', 'email' => 'dp@bmpl.com', 'mobile' => '9928016766', 'emp_id' => 'BK001', 'designation_id' => $designationIds['DP'], 'department_id' => null, 'division_id' => null, 'branch_id' => null, 'location_id' => null, 'segments' => ['Personal', 'Commercial', 'LMM'], 'verticals' => ['New Vehicle', 'Used Vehicle'], 'models' => array_keys($modelIds)],
            ['name' => 'Lokesh Bhati', 'email' => 'ceo@bmpl.com', 'mobile' => '9587893444', 'emp_id' => 'BK002', 'designation_id' => $designationIds['CEO'], 'department_id' => null, 'division_id' => null, 'branch_id' => null, 'location_id' => null, 'segments' => ['Personal', 'Commercial', 'LMM'], 'verticals' => ['New Vehicle', 'Used Vehicle'], 'models' => array_keys($modelIds), 'reportings' => [['reporting_to' => 'BK001']]],
            ['name' => 'Ajay Pal Chauhan', 'email' => 'ap.banna@gmail.com', 'mobile' => '8890173846', 'emp_id' => 'BK003', 'designation_id' => $designationIds['CX Manager'], 'department_id' => $departmentIds['Sales'], 'division_id' => $divisionIds['New Vehicle Sales'], 'branch_id' => $branchIds['Bikaner'], 'location_id' => $locationIds['Bikaner'], 'segments' => ['Personal'], 'verticals' => ['New Vehicle'], 'models' => array_keys($modelIds), 'reportings' => [['reporting_to' => 'BK046', 'segment_id' => $segmentIds['Personal']]]],
            ['name' => 'Rajkumar Sharma', 'email' => 'rajsharmapiim@gmail.com', 'mobile' => '8302626709', 'emp_id' => 'BK004', 'designation_id' => $designationIds['Dy. General Manager'], 'department_id' => $departmentIds['Sales'], 'division_id' => $divisionIds['New Vehicle Sales'], 'branch_id' => $branchIds['Bikaner'], 'location_id' => $locationIds['Bikaner'], 'segments' => ['Commercial'], 'verticals' => ['New Vehicle'], 'models' => array_keys($modelIds)],
            ['name' => 'Neeraj', 'email' => 'neerajalambain@gmail.com', 'mobile' => '9829011194', 'emp_id' => 'BK005', 'designation_id' => $designationIds['General Manager'], 'department_id' => $departmentIds['Sales'], 'division_id' => $divisionIds['Used Vehicle Sales'], 'branch_id' => $branchIds['Bikaner'], 'location_id' => $locationIds['Bikaner'], 'segments' => ['LMM'], 'verticals' => ['Used Vehicle'], 'models' => array_keys($modelIds)],
            ['name' => 'Sunil Bishnoi', 'email' => 'sunilkhadav29@gmail.com', 'mobile' => '8094511229', 'emp_id' => 'BK006', 'designation_id' => $designationIds['Team Leader'], 'department_id' => $departmentIds['Sales'], 'division_id' => $divisionIds['New Vehicle Sales'], 'branch_id' => $branchIds['Bikaner'], 'location_id' => $locationIds['Nokha'], 'segments' => ['Commercial'], 'verticals' => ['New Vehicle'], 'models' => array_keys($modelIds)],
            ['name' => 'Sandeep Bagra', 'email' => 'sandeepbagra144@gmail.com', 'mobile' => '9664355961', 'emp_id' => 'BK007', 'designation_id' => $designationIds['Team Leader'], 'department_id' => $departmentIds['Sales'], 'division_id' => $divisionIds['New Vehicle Sales'], 'branch_id' => $branchIds['Bikaner'], 'location_id' => $locationIds['Sujagarh'], 'segments' => ['Commercial'], 'verticals' => ['New Vehicle'], 'models' => array_keys($modelIds)],
            ['name' => 'Bhupesh Sharma', 'email' => 'sharmabhupesh189@gmail.com', 'mobile' => '9413782878', 'emp_id' => 'BK008', 'designation_id' => $designationIds['Team Leader'], 'department_id' => $departmentIds['Sales'], 'division_id' => $divisionIds['New Vehicle Sales'], 'branch_id' => $branchIds['Bikaner'], 'location_id' => $locationIds['Sri Dungargarh'], 'segments' => ['Commercial'], 'verticals' => ['New Vehicle'], 'models' => array_keys($modelIds)],
            ['name' => 'Manoj Solanki', 'email' => 'mk17793@gmail.com', 'mobile' => '9588296927', 'emp_id' => 'BK009', 'designation_id' => $designationIds['Showroom Sales Consultant'], 'department_id' => $departmentIds['Sales'], 'division_id' => $divisionIds['New Vehicle Sales'], 'branch_id' => $branchIds['Bikaner'], 'location_id' => $locationIds['Bikaner'], 'segments' => ['Commercial'], 'verticals' => ['New Vehicle'], 'models' => array_keys($modelIds)],
            ['name' => 'Sunil Yadav', 'email' => 'sunil.balwar15@gmail.com', 'mobile' => '7222872420', 'emp_id' => 'BK010', 'designation_id' => $designationIds['Showroom Sales Consultant'], 'department_id' => $departmentIds['Sales'], 'division_id' => $divisionIds['New Vehicle Sales'], 'branch_id' => $branchIds['Bikaner'], 'location_id' => $locationIds['Bikaner'], 'segments' => ['Commercial'], 'verticals' => ['New Vehicle'], 'models' => array_keys($modelIds)],
            ['name' => 'Deepak Barasa', 'email' => 'deepakbarasa868@gmail.com', 'mobile' => '8279256669', 'emp_id' => 'BK011', 'designation_id' => $designationIds['Sales Consultant'], 'department_id' => $departmentIds['Sales'], 'division_id' => $divisionIds['New Vehicle Sales'], 'branch_id' => $branchIds['Bikaner'], 'location_id' => $locationIds['Bikaner'], 'segments' => ['Commercial'], 'verticals' => ['New Vehicle'], 'models' => array_keys($modelIds)],
            ['name' => 'Mangi Lal Bishnoi', 'email' => 'pardmangilal@gmail.com', 'mobile' => '9166630029', 'emp_id' => 'BK012', 'designation_id' => $designationIds['Sales Consultant'], 'department_id' => $departmentIds['Sales'], 'division_id' => $divisionIds['New Vehicle Sales'], 'branch_id' => $branchIds['Bikaner'], 'location_id' => $locationIds['Khajuwala'], 'segments' => ['Commercial'], 'verticals' => ['New Vehicle'], 'models' => array_keys($modelIds)],
            ['name' => 'Ganesh Panchariya', 'email' => 'ganeshpanchariya58@gmail.com', 'mobile' => '9983375013', 'emp_id' => 'BK013', 'designation_id' => $designationIds['Sales Consultant'], 'department_id' => $departmentIds['Sales'], 'division_id' => $divisionIds['New Vehicle Sales'], 'branch_id' => $branchIds['Bikaner'], 'location_id' => $locationIds['Kolayat'], 'segments' => ['Commercial'], 'verticals' => ['New Vehicle'], 'models' => array_keys($modelIds)],
            ['name' => 'Daleep Rathore', 'email' => 'daleeprathore20410@gmail.com', 'mobile' => '7023217843', 'emp_id' => 'BK014', 'designation_id' => $designationIds['Sales Consultant'], 'department_id' => $departmentIds['Sales'], 'division_id' => $divisionIds['New Vehicle Sales'], 'branch_id' => $branchIds['Bikaner'], 'location_id' => $locationIds['Nokha'], 'segments' => ['Commercial'], 'verticals' => ['New Vehicle'], 'models' => array_keys($modelIds)],
            ['name' => 'Nemichand Chindaliya', 'email' => 'chindaliyanemichand448@gmail.com', 'mobile' => '7239870987', 'emp_id' => 'BK015', 'designation_id' => $designationIds['Sales Consultant'], 'department_id' => $departmentIds['Sales'], 'division_id' => $divisionIds['New Vehicle Sales'], 'branch_id' => $branchIds['Bikaner'], 'location_id' => $locationIds['Sri Dungargarh'], 'segments' => ['Commercial'], 'verticals' => ['New Vehicle'], 'models' => array_keys($modelIds)],
            ['name' => 'Jai Prakash Pareek', 'email' => 'pareekjp51@gmail.com', 'mobile' => '6350566744', 'emp_id' => 'BK016', 'designation_id' => $designationIds['Sales Consultant'], 'department_id' => $departmentIds['Sales'], 'division_id' => $divisionIds['New Vehicle Sales'], 'branch_id' => $branchIds['Bikaner'], 'location_id' => $locationIds['Napasar'], 'segments' => ['Commercial'], 'verticals' => ['New Vehicle'], 'models' => array_keys($modelIds)],
            ['name' => 'Himanshu Chaturvedi', 'email' => 'himanshuchatrvedi5500@gmail.com', 'mobile' => '7014930775', 'emp_id' => 'BK017', 'designation_id' => $designationIds['Sales Consultant'], 'department_id' => $departmentIds['Sales'], 'division_id' => $divisionIds['New Vehicle Sales'], 'branch_id' => $branchIds['Bikaner'], 'location_id' => $locationIds['Bikaner'], 'segments' => ['Commercial'], 'verticals' => ['New Vehicle'], 'models' => array_keys($modelIds)],
            ['name' => 'Nitesh Godara', 'email' => 'ng8130719576@gmail.com', 'mobile' => '8696988689', 'emp_id' => 'BK018', 'designation_id' => $designationIds['Sales Consultant'], 'department_id' => $departmentIds['Sales'], 'division_id' => $divisionIds['New Vehicle Sales'], 'branch_id' => $branchIds['Bikaner'], 'location_id' => $locationIds['Lunkaransar'], 'segments' => ['Commercial'], 'verticals' => ['New Vehicle'], 'models' => array_keys($modelIds)],
            ['name' => 'Radhe Shyam', 'email' => 'radheshyam8psd@gmail.com', 'mobile' => '9660974841', 'emp_id' => 'BK019', 'designation_id' => $designationIds['Sales Consultant'], 'department_id' => $departmentIds['Sales'], 'division_id' => $divisionIds['New Vehicle Sales'], 'branch_id' => $branchIds['Bikaner'], 'location_id' => $locationIds['Chhatargarh'], 'segments' => ['Commercial'], 'verticals' => ['New Vehicle'], 'models' => array_keys($modelIds)],
            ['name' => 'Pawan Pareek', 'email' => 'pp314043@gmail.com', 'mobile' => '9571863491', 'emp_id' => 'BK020', 'designation_id' => $designationIds['Sales Consultant'], 'department_id' => $departmentIds['Sales'], 'division_id' => $divisionIds['New Vehicle Sales'], 'branch_id' => $branchIds['Bikaner'], 'location_id' => $locationIds['Bikaner'], 'segments' => ['Commercial'], 'verticals' => ['New Vehicle'], 'models' => array_keys($modelIds)],
            ['name' => 'Bhuwnesh Paiwal', 'email' => 'bhuwneshpaliwal2019@gmail.com', 'mobile' => '6375279944', 'emp_id' => 'BK021', 'designation_id' => $designationIds['Sales Consultant'], 'department_id' => $departmentIds['Sales'], 'division_id' => $divisionIds['New Vehicle Sales'], 'branch_id' => $branchIds['Bikaner'], 'location_id' => $locationIds['Bikaner'], 'segments' => ['Commercial'], 'verticals' => ['New Vehicle'], 'models' => array_keys($modelIds)],
            ['name' => 'Arjun Singh', 'email' => 'arjunsinghas692128@gmail.com', 'mobile' => '9588253677', 'emp_id' => 'BK022', 'designation_id' => $designationIds['Sales Consultant'], 'department_id' => $departmentIds['Sales'], 'division_id' => $divisionIds['New Vehicle Sales'], 'branch_id' => $branchIds['Bikaner'], 'location_id' => $locationIds['Sujagarh'], 'segments' => ['Commercial'], 'verticals' => ['New Vehicle'], 'models' => array_keys($modelIds)],
            ['name' => 'Sharwan Jakhar', 'email' => 'shrawanjakhar1999@gmail.com', 'mobile' => '7378131327', 'emp_id' => 'BK023', 'designation_id' => $designationIds['Sales Consultant'], 'department_id' => $departmentIds['Sales'], 'division_id' => $divisionIds['New Vehicle Sales'], 'branch_id' => $branchIds['Bikaner'], 'location_id' => $locationIds['Sri Dungargarh'], 'segments' => ['Commercial'], 'verticals' => ['New Vehicle'], 'models' => array_keys($modelIds)],
            ['name' => 'Deepmala', 'email' => 'deepmaladeepmala91@gmail.com', 'mobile' => '8561815666', 'emp_id' => 'BK024', 'designation_id' => $designationIds['Showroom Sales Consultant'], 'department_id' => $departmentIds['Sales'], 'division_id' => $divisionIds['Used Vehicle Sales'], 'branch_id' => $branchIds['Bikaner'], 'location_id' => $locationIds['Bikaner'], 'segments' => ['LMM'], 'verticals' => ['Used Vehicle'], 'models' => array_keys($modelIds)],
            ['name' => 'Kaluram Solanki', 'email' => 'solankikaluram79@gmail.com', 'mobile' => '9602117334', 'emp_id' => 'BK025', 'designation_id' => $designationIds['Sales Consultant'], 'department_id' => $departmentIds['Sales'], 'division_id' => $divisionIds['Used Vehicle Sales'], 'branch_id' => $branchIds['Bikaner'], 'location_id' => $locationIds['Sri Dungargarh'], 'segments' => ['LMM'], 'verticals' => ['Used Vehicle'], 'models' => array_keys($modelIds)],
            ['name' => 'Farooq Khan', 'email' => 'fkj9099@gmail.com', 'mobile' => '7611090850', 'emp_id' => 'BK026', 'designation_id' => $designationIds['Sales Consultant'], 'department_id' => $departmentIds['Sales'], 'division_id' => $divisionIds['Used Vehicle Sales'], 'branch_id' => $branchIds['Bikaner'], 'location_id' => $locationIds['Bikaner'], 'segments' => ['LMM'], 'verticals' => ['Used Vehicle'], 'models' => array_keys($modelIds)],
            ['name' => 'Salman Khan', 'email' => 'salmankhannuri30@gmail.com', 'mobile' => '8949420178', 'emp_id' => 'BK027', 'designation_id' => $designationIds['Sales Consultant'], 'department_id' => $departmentIds['Sales'], 'division_id' => $divisionIds['Used Vehicle Sales'], 'branch_id' => $branchIds['Bikaner'], 'location_id' => $locationIds['Bikaner'], 'segments' => ['LMM'], 'verticals' => ['Used Vehicle'], 'models' => array_keys($modelIds)],
            ['name' => 'Abid Ali', 'email' => 'reshmabano3236@gmail.com', 'mobile' => '7014103347', 'emp_id' => 'BK028', 'designation_id' => $designationIds['Sales Consultant'], 'department_id' => $departmentIds['Sales'], 'division_id' => $divisionIds['Used Vehicle Sales'], 'branch_id' => $branchIds['Bikaner'], 'location_id' => $locationIds['Bikaner'], 'segments' => ['LMM'], 'verticals' => ['Used Vehicle'], 'models' => array_keys($modelIds)],
            ['name' => 'Rahul Rathore', 'email' => 'rahulbannarathaur@gmail.com', 'mobile' => '9587312402', 'emp_id' => 'BK029', 'designation_id' => $designationIds['Sales Consultant'], 'department_id' => $departmentIds['Sales'], 'division_id' => $divisionIds['Used Vehicle Sales'], 'branch_id' => $branchIds['Bikaner'], 'location_id' => $locationIds['Nokha'], 'segments' => ['LMM'], 'verticals' => ['Used Vehicle'], 'models' => array_keys($modelIds)],
            ['name' => 'Kanaram', 'email' => 'kanaramv34@gmail.com', 'mobile' => '7725969600', 'emp_id' => 'BK030', 'designation_id' => $designationIds['Sales Consultant'], 'department_id' => $departmentIds['Sales'], 'division_id' => $divisionIds['Used Vehicle Sales'], 'branch_id' => $branchIds['Bikaner'], 'location_id' => $locationIds['Khajuwala'], 'segments' => ['LMM'], 'verticals' => ['Used Vehicle'], 'models' => array_keys($modelIds)],
            ['name' => 'Parvat Singh', 'email' => 'parvatsingh4042@gmail.com', 'mobile' => '8302674431', 'emp_id' => 'BK031', 'designation_id' => $designationIds['Sales Consultant'], 'department_id' => $departmentIds['Sales'], 'division_id' => $divisionIds['Used Vehicle Sales'], 'branch_id' => $branchIds['Bikaner'], 'location_id' => $locationIds['Sujagarh'], 'segments' => ['LMM'], 'verticals' => ['Used Vehicle'], 'models' => array_keys($modelIds)],
            ['name' => 'Pradeep Swami', 'email' => 'pardeepswami666@gmail.com', 'mobile' => '9785848349', 'emp_id' => 'BK032', 'designation_id' => $designationIds['Sales Consultant'], 'department_id' => $departmentIds['Sales'], 'division_id' => $divisionIds['Used Vehicle Sales'], 'branch_id' => $branchIds['Bikaner'], 'location_id' => $locationIds['Lunkaransar'], 'segments' => ['LMM'], 'verticals' => ['Used Vehicle'], 'models' => array_keys($modelIds)],
            ['name' => 'Vinod Gujjar', 'email' => 'vishalgurjar901@gmail.com', 'mobile' => '7737809142', 'emp_id' => 'BK033', 'designation_id' => $designationIds['Sales Manager'], 'department_id' => $departmentIds['Sales'], 'division_id' => $divisionIds['New Vehicle Sales'], 'branch_id' => $branchIds['Bikaner'], 'location_id' => $locationIds['Bikaner'], 'segments' => ['Personal'], 'verticals' => ['New Vehicle'], 'models' => array_keys($modelIds)],
            ['name' => 'Gourav Suntwal', 'email' => 'gouravsuntwal25@gmail.com', 'mobile' => '9672722455', 'emp_id' => 'BK034', 'designation_id' => $designationIds['Sales Manager'], 'department_id' => $departmentIds['Sales'], 'division_id' => $divisionIds['New Vehicle Sales'], 'branch_id' => $branchIds['Bikaner'], 'location_id' => $locationIds['Bikaner'], 'segments' => ['Personal'], 'verticals' => ['New Vehicle'], 'models' => array_keys($modelIds), 'reportings' => [['reporting_to' => 'BK046', 'segment_id' => $segmentIds['Personal']]]],
            ['name' => 'Manju Chauhan', 'email' => 'mikkuchauhan8@gmail.com', 'mobile' => '8696030323', 'emp_id' => 'BK035', 'designation_id' => $designationIds['Sales Consultant'], 'department_id' => $departmentIds['Sales'], 'division_id' => $divisionIds['New Vehicle Sales'], 'branch_id' => $branchIds['Bikaner'], 'location_id' => $locationIds['Bikaner'], 'segments' => ['Personal'], 'verticals' => ['New Vehicle'], 'models' => ['XUV3XO', 'XUV400', 'XUV700'], 'cash_disc_power' => ['Any' => 1000, 'XUV3XO' => 1500], 'reportings' => [
                ['reporting_to' => 'BK003', 'segment_id' => $segmentIds['Personal']],
                ['reporting_to' => 'BK034', 'segment_id' => $segmentIds['Personal'], 'model_id' => $modelIds['XUV3XO']],
                ['reporting_to' => 'BK034', 'segment_id' => $segmentIds['Personal'], 'model_id' => $modelIds['XUV400']],
                ['reporting_to' => 'BK034', 'segment_id' => $segmentIds['Personal'], 'model_id' => $modelIds['XUV700']],
            ]],
            ['name' => 'Mahendra Gedhar', 'email' => 'mahendragedar4197@gmail.com', 'mobile' => '9982402263', 'emp_id' => 'BK036', 'designation_id' => $designationIds['Sales Consultant'], 'department_id' => $departmentIds['Sales'], 'division_id' => $divisionIds['New Vehicle Sales'], 'branch_id' => $branchIds['Bikaner'], 'location_id' => $locationIds['Khajuwala'], 'segments' => ['Personal'], 'verticals' => ['New Vehicle'], 'models' => array_keys($modelIds)],
            ['name' => 'Vikash Paiwal', 'email' => 'vikaspaiwal7@gmail.com', 'mobile' => '7737561520', 'emp_id' => 'BK037', 'designation_id' => $designationIds['Sales Consultant'], 'department_id' => $departmentIds['Sales'], 'division_id' => $divisionIds['New Vehicle Sales'], 'branch_id' => $branchIds['Bikaner'], 'location_id' => $locationIds['Kolayat'], 'segments' => ['Personal'], 'verticals' => ['New Vehicle'], 'models' => array_keys($modelIds)],
            ['name' => 'Kishan Parihar', 'email' => 'kishanparihar131@gmail.com', 'mobile' => '9680933734', 'emp_id' => 'BK038', 'designation_id' => $designationIds['Sales Consultant'], 'department_id' => $departmentIds['Sales'], 'division_id' => $divisionIds['New Vehicle Sales'], 'branch_id' => $branchIds['Bikaner'], 'location_id' => $locationIds['Sri Dungargarh'], 'segments' => ['Personal'], 'verticals' => ['New Vehicle'], 'models' => array_keys($modelIds)],
            ['name' => 'Abhilash Jawa', 'email' => 'abhilashjawa9@gmail.com', 'mobile' => '7728082113', 'emp_id' => 'BK039', 'designation_id' => $designationIds['Sales Consultant'], 'department_id' => $departmentIds['Sales'], 'division_id' => $divisionIds['New Vehicle Sales'], 'branch_id' => $branchIds['Bikaner'], 'location_id' => $locationIds['Bikaner'], 'segments' => ['Personal'], 'verticals' => ['New Vehicle'], 'models' => array_keys($modelIds)],
            ['name' => 'Rajendra Hansasar', 'email' => 'rajendra.hansasar@gmail.com', 'mobile' => '7976377443', 'emp_id' => 'BK040', 'designation_id' => $designationIds['Sales Consultant'], 'department_id' => $departmentIds['Sales'], 'division_id' => $divisionIds['New Vehicle Sales'], 'branch_id' => $branchIds['Bikaner'], 'location_id' => $locationIds['Bikaner'], 'segments' => ['Personal'], 'verticals' => ['New Vehicle'], 'models' => array_keys($modelIds)],
            ['name' => 'Renu Shekhawat', 'email' => 'shekhawatrenu41@gmail.com', 'mobile' => '9050574634', 'emp_id' => 'BK041', 'designation_id' => $designationIds['Sales Consultant'], 'department_id' => $departmentIds['Sales'], 'division_id' => $divisionIds['New Vehicle Sales'], 'branch_id' => $branchIds['Bikaner'], 'location_id' => $locationIds['Bikaner'], 'segments' => ['Personal'], 'verticals' => ['New Vehicle'], 'models' => array_keys($modelIds)],
            ['name' => 'Kamal Kumar Khichi', 'email' => 'kamalkhalwa@gmail.com', 'mobile' => '7732865857', 'emp_id' => 'BK042', 'designation_id' => $designationIds['Sales Consultant'], 'department_id' => $departmentIds['Sales'], 'division_id' => $divisionIds['New Vehicle Sales'], 'branch_id' => $branchIds['Bikaner'], 'location_id' => $locationIds['Sujagarh'], 'segments' => ['Personal'], 'verticals' => ['New Vehicle'], 'models' => array_keys($modelIds)],
            ['name' => 'Deependra Singh Rathore', 'email' => 'deepj2542@gmail.com', 'mobile' => '7823871722', 'emp_id' => 'BK043', 'designation_id' => $designationIds['Sales Consultant'], 'department_id' => $departmentIds['Sales'], 'division_id' => $divisionIds['New Vehicle Sales'], 'branch_id' => $branchIds['Bikaner'], 'location_id' => $locationIds['Bikaner'], 'segments' => ['Personal'], 'verticals' => ['New Vehicle'], 'models' => array_keys($modelIds)],
            ['name' => 'Ashvini Joshi', 'email' => 'joshi2345774@gmail.com', 'mobile' => '7791094914', 'emp_id' => 'BK044', 'designation_id' => $designationIds['Sales Consultant'], 'department_id' => $departmentIds['Sales'], 'division_id' => $divisionIds['New Vehicle Sales'], 'branch_id' => $branchIds['Bikaner'], 'location_id' => $locationIds['Bikaner'], 'segments' => ['Personal'], 'verticals' => ['New Vehicle'], 'models' => array_keys($modelIds)],
            ['name' => 'Manohar Swami', 'email' => 'swamimanohar454@gmail.com', 'mobile' => '8955815781', 'emp_id' => 'BK045', 'designation_id' => $designationIds['Sales Consultant'], 'department_id' => $departmentIds['Sales'], 'division_id' => $divisionIds['New Vehicle Sales'], 'branch_id' => $branchIds['Bikaner'], 'location_id' => $locationIds['Lunkaransar'], 'segments' => ['Personal'], 'verticals' => ['New Vehicle'], 'models' => array_keys($modelIds)],
            ['name' => 'Tribhuvan Tanwar', 'email' => 'tribhuwantiru7@gmail.com', 'mobile' => '9414143571', 'emp_id' => 'BK046', 'designation_id' => $designationIds['Dy. General Manager'], 'department_id' => $departmentIds['Sales'], 'division_id' => $divisionIds['New Vehicle Sales'], 'branch_id' => $branchIds['Bikaner'], 'location_id' => $locationIds['Bikaner'], 'segments' => ['Personal'], 'verticals' => ['New Vehicle'], 'models' => array_keys($modelIds), 'reportings' => [['reporting_to' => 'BK047', 'segment_id' => $segmentIds['Personal']]]],
            ['name' => 'Ravi Jangid', 'email' => 'jangidravi006@gmail.com', 'mobile' => '8560023026', 'emp_id' => 'BK047', 'designation_id' => $designationIds['General Manager'], 'department_id' => $departmentIds['Sales'], 'division_id' => $divisionIds['New Vehicle Sales'], 'branch_id' => $branchIds['Bikaner'], 'location_id' => $locationIds['Bikaner'], 'segments' => ['Commercial'], 'verticals' => ['New Vehicle'], 'models' => array_keys($modelIds), 'reportings' => [['reporting_to' => 'BK002']]],
            ['name' => 'Devender Rathore', 'email' => 'dav.bmpl@gmail.com', 'mobile' => '9829377300', 'emp_id' => 'CH001', 'designation_id' => $designationIds['Sales Manager'], 'department_id' => $departmentIds['Sales'], 'division_id' => $divisionIds['New Vehicle Sales'], 'branch_id' => $branchIds['Churu'], 'location_id' => $locationIds['Churu'], 'segments' => ['Commercial'], 'verticals' => ['New Vehicle'], 'models' => array_keys($modelIds)],
            ['name' => 'Anand Jangir', 'email' => 'anandjangid1533@gmail.com', 'mobile' => '9928413888', 'emp_id' => 'CH002', 'designation_id' => $designationIds['Sales Consultant'], 'department_id' => $departmentIds['Sales'], 'division_id' => $divisionIds['New Vehicle Sales'], 'branch_id' => $branchIds['Churu'], 'location_id' => $locationIds['Rajgarh'], 'segments' => ['Commercial'], 'verticals' => ['New Vehicle'], 'models' => array_keys($modelIds)],
            ['name' => 'Ashok Rathore', 'email' => 'ashoksinghrathore7356@gmail.com', 'mobile' => '8875384966', 'emp_id' => 'CH003', 'designation_id' => $designationIds['Sales Consultant'], 'department_id' => $departmentIds['Sales'], 'division_id' => $divisionIds['New Vehicle Sales'], 'branch_id' => $branchIds['Churu'], 'location_id' => $locationIds['Sardarshahar'], 'segments' => ['Commercial'], 'verticals' => ['New Vehicle'], 'models' => array_keys($modelIds)],
            ['name' => 'Jay Singh Chauhan', 'email' => 'jaysinghchouhan444@gmail.com', 'mobile' => '9461135729', 'emp_id' => 'CH004', 'designation_id' => $designationIds['Sales Consultant'], 'department_id' => $departmentIds['Sales'], 'division_id' => $divisionIds['New Vehicle Sales'], 'branch_id' => $branchIds['Churu'], 'location_id' => $locationIds['Ratangarh'], 'segments' => ['Commercial'], 'verticals' => ['New Vehicle'], 'models' => array_keys($modelIds)],
            ['name' => 'Manish Kumar Pareek', 'email' => 'mpareek452@gmail.com', 'mobile' => '9772543860', 'emp_id' => 'CH005', 'designation_id' => $designationIds['Sales Consultant'], 'department_id' => $departmentIds['Sales'], 'division_id' => $divisionIds['New Vehicle Sales'], 'branch_id' => $branchIds['Churu'], 'location_id' => $locationIds['Bhanipura'], 'segments' => ['Commercial'], 'verticals' => ['New Vehicle'], 'models' => array_keys($modelIds)],
            ['name' => 'Kinkar Singh', 'email' => 'kinkarsahu049@gnail.com', 'mobile' => '9772636720', 'emp_id' => 'CH006', 'designation_id' => $designationIds['Sales Consultant'], 'department_id' => $departmentIds['Sales'], 'division_id' => $divisionIds['New Vehicle Sales'], 'branch_id' => $branchIds['Churu'], 'location_id' => $locationIds['Sidmukkh'], 'segments' => ['Commercial'], 'verticals' => ['New Vehicle'], 'models' => array_keys($modelIds)],
            ['name' => 'Vikram Dev', 'email' => 'vikrambidsar@gmail.com', 'mobile' => '8005720736', 'emp_id' => 'CH007', 'designation_id' => $designationIds['Sales Manager'], 'department_id' => $departmentIds['Sales'], 'division_id' => $divisionIds['Used Vehicle Sales'], 'branch_id' => $branchIds['Churu'], 'location_id' => $locationIds['Churu'], 'segments' => ['LMM'], 'verticals' => ['Used Vehicle'], 'models' => array_keys($modelIds)],
            ['name' => 'Sarfaraz Ahmed', 'email' => 'sarfaraazahamedqureshi@gmail.com', 'mobile' => '8619771640', 'emp_id' => 'CH008', 'designation_id' => $designationIds['Sales Consultant'], 'department_id' => $departmentIds['Sales'], 'division_id' => $divisionIds['Used Vehicle Sales'], 'branch_id' => $branchIds['Churu'], 'location_id' => $locationIds['Churu'], 'segments' => ['LMM'], 'verticals' => ['Used Vehicle'], 'models' => array_keys($modelIds)],
            ['name' => 'Mukesh Saini', 'email' => 'mukeshsainimahindrasardarshar@gmail.com', 'mobile' => '8529609647', 'emp_id' => 'CH009', 'designation_id' => $designationIds['Sales Consultant'], 'department_id' => $departmentIds['Sales'], 'division_id' => $divisionIds['Used Vehicle Sales'], 'branch_id' => $branchIds['Churu'], 'location_id' => $locationIds['Churu'], 'segments' => ['LMM'], 'verticals' => ['Used Vehicle'], 'models' => array_keys($modelIds)],
            ['name' => 'Mukesh Saini', 'email' => 'mukeshsaini.mk93@gmail.com', 'mobile' => '9024560069', 'emp_id' => 'CH010', 'designation_id' => $designationIds['Sales Consultant'], 'department_id' => $departmentIds['Sales'], 'division_id' => $divisionIds['Used Vehicle Sales'], 'branch_id' => $branchIds['Churu'], 'location_id' => $locationIds['Churu'], 'segments' => ['LMM'], 'verticals' => ['Used Vehicle'], 'models' => array_keys($modelIds)],
            ['name' => 'Shahbaz Khan', 'email' => 'shahbazkhan988141@gmail.com', 'mobile' => '9610763862', 'emp_id' => 'CH011', 'designation_id' => $designationIds['Sales Consultant'], 'department_id' => $departmentIds['Sales'], 'division_id' => $divisionIds['New Vehicle Sales'], 'branch_id' => $branchIds['Churu'], 'location_id' => $locationIds['Ratangarh'], 'segments' => ['Personal'], 'verticals' => ['New Vehicle'], 'models' => array_keys($modelIds)],
            ['name' => 'Mukesh Prajapat', 'email' => 'imukeshkumarprajapat@gmail.com', 'mobile' => '7891091376', 'emp_id' => 'CH012', 'designation_id' => $designationIds['Sales Consultant'], 'department_id' => $departmentIds['Sales'], 'division_id' => $divisionIds['New Vehicle Sales'], 'branch_id' => $branchIds['Churu'], 'location_id' => $locationIds['Sardarshahar'], 'segments' => ['Personal'], 'verticals' => ['New Vehicle'], 'models' => array_keys($modelIds)],
            ['name' => 'Ramchandra Prajapat', 'email' => 'ramchanderprajapat517@gmail.com', 'mobile' => '9079210804', 'emp_id' => 'CH013', 'designation_id' => $designationIds['Sales Consultant'], 'department_id' => $departmentIds['Sales'], 'division_id' => $divisionIds['New Vehicle Sales'], 'branch_id' => $branchIds['Churu'], 'location_id' => $locationIds['Churu'], 'segments' => ['Personal'], 'verticals' => ['New Vehicle'], 'models' => array_keys($modelIds)],
            ['name' => 'Gajendra Rathore', 'email' => 'gajendrarathore622@gmail.com', 'mobile' => '8890488765', 'emp_id' => 'CH014', 'designation_id' => $designationIds['Sales Consultant'], 'department_id' => $departmentIds['Sales'], 'division_id' => $divisionIds['New Vehicle Sales'], 'branch_id' => $branchIds['Churu'], 'location_id' => $locationIds['Rajgarh'], 'segments' => ['Personal'], 'verticals' => ['New Vehicle'], 'models' => array_keys($modelIds)],
            ['name' => 'Soyab Khan', 'email' => 'soyabs9790@gmail.com', 'mobile' => '9145958230', 'emp_id' => 'CH015', 'designation_id' => $designationIds['Sales Consultant'], 'department_id' => $departmentIds['Sales'], 'division_id' => $divisionIds['New Vehicle Sales'], 'branch_id' => $branchIds['Churu'], 'location_id' => $locationIds['Churu'], 'segments' => ['Personal'], 'verticals' => ['New Vehicle'], 'models' => array_keys($modelIds)],
            ['name' => 'Virendra Rathore', 'email' => 'rathorevirendra595@gmail.com', 'mobile' => '9660100122', 'emp_id' => 'CH016', 'designation_id' => $designationIds['Sales Consultant'], 'department_id' => $departmentIds['Sales'], 'division_id' => $divisionIds['New Vehicle Sales'], 'branch_id' => $branchIds['Churu'], 'location_id' => $locationIds['Taranagar'], 'segments' => ['Personal'], 'verticals' => ['New Vehicle'], 'models' => array_keys($modelIds)],
            ['name' => 'Govind Singh Rathore', 'email' => 'govindrathore902@gmail.com', 'mobile' => '6376064805', 'emp_id' => 'CH017', 'designation_id' => $designationIds['Sales Consultant'], 'department_id' => $departmentIds['Sales'], 'division_id' => $divisionIds['New Vehicle Sales'], 'branch_id' => $branchIds['Churu'], 'location_id' => $locationIds['Churu'], 'segments' => ['Personal'], 'verticals' => ['New Vehicle'], 'models' => array_keys($modelIds)],
            ['name' => 'Farooq Khan', 'email' => 'farooqkhan954@gmail.com', 'mobile' => '7023568965', 'emp_id' => 'CH018', 'designation_id' => $designationIds['Sales Manager'], 'department_id' => $departmentIds['Sales'], 'division_id' => $divisionIds['New Vehicle Sales'], 'branch_id' => $branchIds['Churu'], 'location_id' => $locationIds['Churu'], 'segments' => ['Personal'], 'verticals' => ['New Vehicle'], 'models' => array_keys($modelIds)],
        ];

        $users = [];
        foreach ($usersData as $data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'mobile' => $data['mobile'],
                'emp_id' => $data['emp_id'],
                'password' => Hash::make('password'),
                'designation_id' => $data['designation_id'],
                'department_id' => $data['department_id'],
                'division_id' => $data['division_id'],
                'branch_id' => $data['branch_id'],
                'location_id' => $data['location_id'],
                'cash_disc_power' => $data['cash_disc_power'] ?? null,
                'status' => 1,
            ]);
            $users[$data['emp_id']] = $user;

            // Attach Segments
            foreach ($data['segments'] as $segment) {
                $user->segments()->attach($segmentIds[$segment]);
            }

            // Attach Verticals
            foreach ($data['verticals'] as $vertical) {
                $user->verticals()->attach($verticalIds[$vertical]);
            }

            // Attach Models
            foreach ($data['models'] as $model) {
                $user->models()->attach($modelIds[$model]);
            }

            // Attach Reportings
            if (isset($data['reportings'])) {
                foreach ($data['reportings'] as $reporting) {
                    UserReporting::create([
                        'user_id' => $user->id,
                        'reporting_to_id' => $users[$reporting['reporting_to']]->id,
                        'segment_id' => $reporting['segment_id'] ?? null,
                        'model_id' => $reporting['model_id'] ?? null,
                        'vertical_id' => $reporting['vertical_id'] ?? null,
                        'branch_id' => $reporting['branch_id'] ?? null,
                        'location_id' => $reporting['location_id'] ?? null,
                        'department_id' => $reporting['department_id'] ?? null,
                        'division_id' => $reporting['division_id'] ?? null,
                    ]);
                }
            }
        }
    }
}
