<?php 
$I = new AcceptanceTester($scenario);
$I->wantTo('Insert a users');
$I->amOnPage('/UserController.php/?route=insert');
$I->fillField('firstName', 'testFirst');
$I->fillField('lastName', 'testLast');
$I->fillField('age', '12');
$I->fillField('username', 'TestUser');
$I->click('Submit');
$I->see('testFirst');
