<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

require 'lib/data.model.php';


final class DataModelTest extends TestCase
{
    public function testGuid() {
        $this->assertRegExp(
            '/^\{.{36}\}$/',
            Guid()
        );
    }
    public function testGet_string_between() {
        $this->assertSame(
            Get_string_between(
                'This <start> is <end> the string',
                '<start>',
                '<end>'
            ),
            ' is '
        );
    }
    public function testValidate_field() {
        $this->assertSame(
            Validate_field(
                'DAVE','MembershipID'
            ),
            'Membership ID: Must be numbers only'
        );
    }
    public function testValidate_fields_Dojoname()
    {
        $result = Validate_field('1Lwtest', 'DojoName');
        $this->assertSame($result, 'Dojo Name: Must be alphanumeric only', 'test Validate_field Dojoname');
        $result = Validate_field('Lwtest', 'DojoName');
        $this->assertSame($result, null, 'test Validate_field Dojoname 2');
    }

}
