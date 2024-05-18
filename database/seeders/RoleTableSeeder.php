<?php

namespace Database\Seeders;

use App\Enum\RoleEnum;
use App\Models\Ability;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Ability::create([
            'name'=> 'all-access'
        ]);

        Ability::create([
            'name'=> 'users-access'
        ]);
        Ability::create([
            'name'=> 'control-personal'
        ]);
        Ability::create([
            'name'=> 'invite-access'
        ]);
        Ability::create([
            'name'=> 'reports-access'
        ]);

        $roleMaster = Role::create([
            'name'=>RoleEnum::Master->name
        ]);

        Role::create([
            'name'=>RoleEnum::Employee->name
        ]);
        Role::create([
            'name'=>RoleEnum::Client->name
        ]);

        // $seller = Role::where('name', 'Seller')->first()->id;
        // $responsible = Role::where('name', 'Responsible')->first()->id;
        $AbilityEmployee = Ability::whereNot('name','control-personal')->whereNot('name','all-access')->pluck('id');
        $abilityClient = Ability::where('name','control-personal')->pluck('id');
        // dd(Ability::where('name','all-access')->first());
        DB::table('role_abilities')->insert([
            'role_id' => RoleEnum::Master,
            'ability_id' => Ability::where('name','all-access')->first()->id,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        foreach($AbilityEmployee as $ab){
            DB::table('role_abilities')->insert([
                'role_id' => RoleEnum::Employee,
                'ability_id' => $ab,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        foreach($abilityClient as $ab){
            DB::table('role_abilities')->insert([
                'role_id' => RoleEnum::Client,
                'ability_id' => $ab,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }




    }

}
