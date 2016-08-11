<?php
    $I = new AcceptanceTester($scenario);
    $I->wantTo('ensure that the page loads');
    $I->amOnPage('/UserController.php?route=show');
    $I->see('Insert a new User');
    $I->see('first name');
