<?php
require_once('../Validation/register_validator.php');
require_once('../Persistence/user_repository.php');
require_once('../Models/createMemberModel.php');
require_once('../Models/createLibrarianModel.php');



$role=$_POST['role'] ?? 'member';
if($role=='librarian'){
    $errorMessage = RegisterValidator::validateLibrarian($_POST['email'], $_POST['password'], $_POST['name'], $_POST['confirm_password']);
    if($errorMessage){
        header("Location: ../Views/register_view.php?errorMessage=$errorMessage");
        exit();
    }
    $userRepository=new UserRepository();
    $createLibrarianModel = new CreateLibrarianModel($_POST['email'], $_POST['name'],$_POST['password']);
    $result= $userRepository->CreateLibrarian($createLibrarianModel);
    if($result){
        header("Location: ../Views/login_view.php");
    }
    else{
        header("Location: ../Views/register_view.php?errorMessage=Email already exists");
    }
}
else{
    $errorMessage = RegisterValidator::validateMember($_POST['email'], $_POST['password'], $_POST['name'], $_POST['contact'], $_POST['membership_id'], $_POST['confirm_password']);
    if($errorMessage){
        header("Location: ../Views/register_view.php?errorMessage=$errorMessage");
        exit();
    }
    $userRepository=new UserRepository();
    $createMemberModel = new CreateMemberModel($_POST['contact'], $_POST['membership_id'], $_POST['email'], $_POST['name'], $_POST['password']);
    $result= $userRepository->createMember($createMemberModel);
    if($result){
        header("Location: ../Views/login_view.php");
    }
    else{
        header("Location: ../Views/register_view.php?errorMessage=Email already exists");
    }
}

// $userRepository = new UserRepository();
// $userRepository->doesEmailExist();
