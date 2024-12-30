<?php
require_once('../Validation/login_validator.php');
require_once('../Persistence/user_repository.php');

function SetLibrarianSessionInformation(LibrarianModel $librarian){
    session_start();
    $_SESSION['librarian_id']=$librarian->librarian_id;
    $_SESSION['name']=$librarian->user->name;
    $_SESSION['email']=$librarian->user->email;
    $_SESSION['role_name']='librarian';
    $_SESSION['user_id']=$librarian->user->id;
}

function SetMemberSessionInformation(MemberModel $member){
    session_start();
    $_SESSION['member_id']=$member->member_id;
    $_SESSION['name']=$member->user->name;
    $_SESSION['email']=$member->user->email;
    $_SESSION['role_name']='member';
    $_SESSION['user_id']=$member->user->id;
    $_SESSION['contact']=$member->contact;
    $_SESSION['membership_id']=$member->membership_id;
}



$email=$_POST['email'];
$password=$_POST['password'];
$roleName=$_POST['roleName'] ?? 'member';
$errorMessage = LoginValidator::validate($email, $password);
if($errorMessage){
    header("Location: ../Views/login_view.php?errorMessage=$errorMessage");
    exit();
}
$userRepository=new UserRepository();
if($roleName=='librarian'){
    $result= $userRepository->getLibrarianByEmailAndPassword($email, $password);
    if($result){
        SetLibrarianSessionInformation($result);
        header("Location: ../Views/my_books.php");
    }
    else{
        header("Location: ../Views/login_view.php?errorMessage=Invalid email or password");
    }
}
else{  
    $result= $userRepository->getMemberByEmailAndPassword($email, $password);
    if($result){
        SetMemberSessionInformation($result);
        header("Location: ../Views/all_books.php");
    }
    else{
        header("Location: ../Views/login_view.php?errorMessage=Invalid email or password");
    }
}


