<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once __DIR__.'/../src/Stylist.php';
    require_once __DIR__.'/../src/Client.php';

    $DB = new PDO('pgsql:host=localhost;dbname=hair_salon_test');

    class StylistTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Stylist::deleteAll();
            Client::deleteAll();
        }

        function testGetStylistName()
        {
            //Arrange
            $stylist_name = "Jane";
            $id = 1;
            $test_stylist = new Stylist($stylist_name, $id);

            //Act
            $result = $test_stylist->getStylistName();

            //Assert
            $this->assertEquals("Jane", $result);
        }

        function testSetStylistName()
        {
            //Arrange
            $stylist_name = "Jane";
            $id = 1;
            $test_stylist = new Stylist($stylist_name, $id);

            //Act
            $test_stylist->setStylistName('Jackie');

            //Assert
            $result = $test_stylist->getStylistName();
            $this->assertEquals("Jackie", $result);
        }

        function testGetId()
        {
            //Arrange
            $stylist_name = "Bob";
            $id = 1;
            $test_stylist = new Stylist($stylist_name, $id);

            //Act
            $result = $test_stylist->getId();

            //Assert
            $this->assertEquals(1, $result);
        }

        function testSetId()
        {
            //Arrange
            $stylist_name = "Gillian";
            $id = 1;
            $test_stylist = new Stylist($stylist_name, $id);

            //Act
            $test_stylist->setId(2);

            //Assert
            $result = $test_stylist->getId();
            $this->assertEquals(2, $result);
        }

        function testSave()
        {
            //Arrange
            $stylist_name = "Peter";
            $id = 1;
            $test_stylist =  new Stylist($stylist_name, $id);

            //Act
            $test_stylist->save();

            //Assert
            $result = Stylist::getAll();
            $this->assertEquals($test_stylist, $result[0]);
        }

        function testFind()
        {
            //Arrange
            $stylist_name =  "Maggie";
            $id = 1;
            $new_stylist = new Stylist($stylist_name, $id);
            $new_stylist->save();
            $stylist_name2 = "Piper";
            $id2 = 2;
            $new_stylist2 = new Stylist($stylist_name2, $id2);
            $new_stylist2->save();

            //Act
            $result = Stylist::find($new_stylist->getId());

            //Assert
            $this->assertEquals($new_stylist, $result);
        }

        function testGetAll()
        {
            //Arrange
            $stylist_name = "Jane";
            $stylist_name2 = "Peter";
            $id = 1;
            $id2= 2;
            $test_stylist = new Stylist($stylist_name, $id);
            $test_stylist2 = new Stylist($stylist_name2, $id2);
            $test_stylist->save();
            $test_stylist2->save();

            //Act
            $result = Stylist::getAll();

            //Assert
            $this->assertEquals([$test_stylist, $test_stylist2], $result);
        }

        function testDeleteAll()
        {
            //Arrange
            $stylist_name = "Jane";
            $stylist_name2 = "Peter";
            $id = 1;
            $id2 = 2;
            $test_stylist = new Stylist($stylist_name, $id);
            $test_stylist2 = new Stylist($stylist_name2, $id2);
            $test_stylist->save();
            $test_stylist2->save();

            //Act
            Stylist::deleteAll();


            //Assert
            $result = Stylist::getAll();
            $this->assertEquals([], $result);
        }

        function testUpdate()
        {
            //Arrange
            $stylist_name = "Maggie";
            $id = 1;
            $test_stylist = new Stylist($stylist_name, $id);
            $test_stylist->save();

            $new_stylist_name = "Mags";

            //Act
            $test_stylist->update($new_stylist_name);

            //Assert
            $this->assertEquals("Mags", $test_stylist->getStylistName());
        }

        function testDelete()
        {
            //Arrange
            $stylist_name = "Maggie";
            $id = 1;
            $new_stylist =  new Stylist($stylist_name, $id);
            $new_stylist->save();

            //Act
            $new_stylist->delete();

            //Assert
            $result = Stylist::getAll();
            $this->assertEquals([], $result);
        }

        function testGetClients()
        {
            //Arrange
            $stylist_name = "Maggie";
            $id = 1;
            $test_stylist = new Stylist($stylist_name, $id);
            $test_stylist->save();

            $stylist_id = $test_stylist->getId();

            $client_name =  "Maggie";
            $id = 1;
            $new_client = new Client($client_name, $stylist_id, $id);
            $new_client->save();
            $client_name2 = "Piper";
            $id2 = 2;
            $new_client2 = new Client($client_name2, $stylist_id, $id2);
            $new_client2->save();

            //Act
            $result = $test_stylist->getClients();

            //Assert
            $this->assertEquals([$new_client, $new_client2], $result);
        }
    }

?>
