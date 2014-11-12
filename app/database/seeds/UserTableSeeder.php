<?php

class UserTableSeeder extends Seeder
{
	public function run()
	{
		//DB::table('users')->delete();
		//DB::table('company_profile')->delete();

		$this->cp(array('name'=>'Farhad Qazi','username' =>'Farhad','cname'=>'Dubai Chamber',
			'clic'=>'123'));
		$this->cp(array('name'=>'Abha Malpani','username' =>'Abha','cname'=>'Dubai Chamber',
			'clic'=>'123'));
		$this->cp(array('name'=>'Omar Khan','username' =>'Omar','cname'=>'Dubai Chamber',
			'clic'=>'123'));
		$this->cp(array('name'=>'Sumesh Nair','username' =>'Sumesh','cname'=>'Dubai Chamber',
			'clic'=>'123'));
		$this->cp(array('name'=>'Paul Raj','username' =>'Paul','cname'=>'Dubai Chamber',
			'clic'=>'123'));
		$this->cp(array('name'=>'Omar Al Ali','username' =>'Omar2','cname'=>'Dubai Chamber',
			'clic'=>'123'));
		$this->cp(array('name'=>'Mahdi Al Mazim','username' =>'Mahdi','cname'=>'Dubai Chamber',
			'clic'=>'123'));

		$this->cp(array('name'=>'Navin Ashokan','username' =>'Navin','cname'=>'VoicEarn',
			'clic'=>'124'));
		$this->cp(array('name'=>'Gaurav Basu','username' =>'Gaurav','cname'=>'VoicEarn',
			'clic'=>'124'));

		$this->cp(array('name'=>'Vikas Mohandas','username' =>'Vikas','cname'=>'Orange',
			'clic'=>'125'));
		$this->cp(array('name'=>'Sajin M','username' =>'Sajin','cname'=>'Orange',
			'clic'=>'125'));
		$this->cp(array('name'=>'Sreejith S','username' =>'Sreejith','cname'=>'Orange',
			'clic'=>'125'));
		$this->cp(array('name'=>'Sushil Soman','username' =>'Sushil','cname'=>'Orange',
			'clic'=>'125'));

		$this->cp(array('name'=>'Muhammad Mumaij','username' =>'Muhammad','cname'=>'Star General Trading Co.',
			'clic'=>'126'));
		$this->cp(array('name'=>'Ali Zafar','username' =>'Ali','cname'=>'Star General Trading Co.',
			'clic'=>'126'));
		$this->cp(array('name'=>'Tony Boulos','username' =>'Tony','cname'=>'Star General Trading Co.',
			'clic'=>'126'));
		$this->cp(array('name'=>'Fawaz Ibrahim','username' =>'Fawaz','cname'=>'Star General Trading Co.',
			'clic'=>'126'));

		$this->cp(array('name'=>'Paul Christodolou','username' =>'Paul','cname'=>'Kendal Real Estate',
			'clic'=>'127'));
		$this->cp(array('name'=>'David Terry','username' =>'David','cname'=>'Kendal Real Estate',
			'clic'=>'127'));
		$this->cp(array('name'=>'Jessica Watson','username' =>'Jessica','cname'=>'Kendal Real Estate',
			'clic'=>'127'));
		$this->cp(array('name'=>'Oscar Cummins','username' =>'Oscar','cname'=>'Kendal Real Estate',
			'clic'=>'127'));


		$this->cp(array('name'=>'Vijith Sivadasan','username' =>'Vijith','cname'=>'Codelattice',
			'clic'=>'128'));
		$this->cp(array('name'=>'Nipun B','username' =>'Nipun','cname'=>'Codelattice',
			'clic'=>'128'));
		$this->cp(array('name'=>'Axel B','username' =>'Axel','cname'=>'Codelattice',
			'clic'=>'128'));
		$this->cp(array('name'=>'Hemanth AP','username' =>'Hemanth','cname'=>'Codelattice',
			'clic'=>'128'));

		$this->cp(array('name'=>'Sanjay Gawade','username' =>'Sanjay','cname'=>'Spiral​ Advertising',
			'clic'=>'129'));
		$this->cp(array('name'=>'Shehzad Yunus','username' =>'Shehzad','cname'=>'Spiral​ Advertising',
			'clic'=>'129'));

		$this->cp(array('name'=>'Nirav Bhagat','username' =>'Nirav','cname'=>'Just Print',
			'clic'=>'130'));
		$this->cp(array('name'=>'Muzammil G','username' =>'Muzammil','cname'=>'Just Print',
			'clic'=>'130'));
		$this->cp(array('name'=>'Niyaz T.','username' =>'Niyaz','cname'=>'Just Print',
			'clic'=>'130'));

		$this->cp(array('name'=>'Krishnan A','username' =>'Krishnan','cname'=>'Support Mena',
			'clic'=>'131'));
		$this->cp(array('name'=>'Anil Krishnan','username' =>'Anil','cname'=>'Support Mena',
			'clic'=>'131'));
		$this->cp(array('name'=>'Ragesh S.','username' =>'Ragesh','cname'=>'Support Mena',
			'clic'=>'131'));

		$this->cp(array('name'=>'Irwin Pinto','username' =>'Irwin','cname'=>'Magnus Advertising',
			'clic'=>'132'));
		$this->cp(array('name'=>'Sanal C','username' =>'Sanal','cname'=>'Magnus Advertising',
			'clic'=>'132'));
		$this->cp(array('name'=>'Reshmi S','username' =>'Reshmi','cname'=>'Magnus Advertising',
			'clic'=>'132'));
		$this->cp(array('name'=>'Rahul Sharma','username' =>'Rahul','cname'=>'Magnus Advertising',
			'clic'=>'132'));
		$this->cp(array('name'=>'Amit Arora','username' =>'Amit','cname'=>'Magnus Advertising',
			'clic'=>'132'));

		$this->cp(array('name'=>'Ayaz M.','username' =>'Ayaz','cname'=>'V. Pro',
			'clic'=>'133'));
		$this->cp(array('name'=>'Jack Anderson','username' =>'Jack','cname'=>'V. Pro',
			'clic'=>'133'));

	}

	private function cp($arr)
	{
			$usr = User::create(array(
			'name'     => $arr['name'],
			'username' => $arr['username'],
			'email'    => 'sample@sample.com',
			'password' => Hash::make('password'),
			'mobile'   => 1234567890,
			)
		);
		CompanyProfile::create(array(
			'user_id' => $usr->id,
			'company_name' => $arr['cname'],
			'company_email' => 'sample@company.com',
			'designation' => 'staff',
			'trade_license_number' => $arr['clic']
			)
		);
	}
}