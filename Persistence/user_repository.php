<?php
require_once('db_connection.php');
require_once('../Models/memberModel.php');
require_once('../Models/librarianModel.php');
require_once('../Models/roleModel.php');
require_once('../Models/userModel.php');
require_once('../Models/createMemberModel.php');
require_once('../Models/createLibrarianModel.php');

class UserRepository
{
    private $conn;

    public function __construct() {
        $dbConnection = new DbConnection();
        $this->conn = $dbConnection->conn;
    }

    function createMember(CreateMemberModel $createMemberModel)
    {
        $conn=$this->conn;
        //insert transactions into database consecutively
        $conn->begin_transaction();

        try {
            $sql = "INSERT INTO users(email, name, password, role_id) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);

            if ($stmt) {
                $role_id = 2;
                $stmt->bind_param('sssi', $createMemberModel->email, $createMemberModel->name, $createMemberModel->password, $role_id);
                $stmt->execute();

                $lastInsertId = $conn->insert_id;

                $sql2 = "INSERT INTO members(contact, membership_id, user_id) VALUES (?, ?, ?)";
                $stmt2 = $conn->prepare($sql2);

                if ($stmt2) {
                    $stmt2->bind_param('ssi', $createMemberModel->contact, $createMemberModel->membership_id, $lastInsertId);
                    $stmt2->execute();

                    $conn->commit();
                    $stmt->close();
                    $stmt2->close();
                } else {
                    throw new Exception("Failed to prepare statement 2");
                }
            } else {
                throw new Exception("Failed to prepare statement 1");
            }
        } catch (Exception $e) {
            $conn->rollback();
            return false;
        }
        return true;
    }

    function createLibrarian(CreateLibrarianModel $createLibrarianModel)
    {
        $conn=$this->conn;
        $conn->begin_transaction();

        try {
            $sql = "INSERT INTO users(email, name, password, role_id) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);

            if ($stmt) {
                $role_id = 1;
                $stmt->bind_param('sssi', $createLibrarianModel->email, $createLibrarianModel->name, $createLibrarianModel->password, $role_id);
                $stmt->execute();

                $lastInsertId = $conn->insert_id;

                $sql2 = "INSERT INTO librarians(user_id) VALUES (?)";
                $stmt2 = $conn->prepare($sql2);

                if ($stmt2) {
                    $stmt2->bind_param('i', $lastInsertId);
                    $stmt2->execute();

                    $conn->commit();
                    $stmt->close();
                    $stmt2->close();
                } else {
                    throw new Exception("Failed to prepare statement 2");
                }
            } else {
                throw new Exception("Failed to prepare statement 1");
            }
        } catch (Exception $e) {
            $conn->rollback();
            return false;
        }
        return true;

    }

    function doesEmailExist(string $email): bool
    {
        $conn=$this->conn;
        $count = 0;
        $sql = "SELECT COUNT(id) FROM users WHERE email=?";
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param('s', $email);
            $stmt->execute();
            $stmt->bind_result($count);
            $stmt->fetch();
            $stmt->close();

            return $count > 0;
        } else {
            throw new Exception("Failed to prepare statement");
        }
    }

    function getLibrarianByEmailAndPassword(string $email, string $password)
    {
        $conn=$this->conn;
        $sql = "SELECT 
            librarians.id AS librarian_id, 
            users.id AS user_id, 
            users.email, 
            users.name, 
            users.password, 
            roles.id AS role_id, 
            roles.name AS role_name 
            FROM librarians 
            INNER JOIN users ON users.id = librarians.user_id 
            INNER JOIN roles ON roles.id = users.role_id 
            WHERE users.email = ? AND users.password = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param('ss', $email, $password);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $stmt->close();

            if ($row) {
                return new LibrarianModel(
                    $row['librarian_id'],
                    new UserModel(
                        $row['user_id'],
                        $row['email'],
                        $row['name'],
                        new RoleModel($row['role_id'], $row['role_name'])
                    )
                );
            } else {
                return null; // or handle the case where no record is found
            }
        } else {
            throw new Exception("Failed to prepare statement");
        }
    }

    function getMemberByEmailAndPassword(string $email, string $password)
    {
        $conn=$this->conn;
        $sql = "SELECT 
            members.id AS member_id, 
            members.contact, 
            members.membership_id, 
            users.id AS user_id, 
            users.email, 
            users.name, 
            users.password, 
            roles.id AS role_id, 
            roles.name AS role_name 
            FROM members 
            INNER JOIN users ON users.id = members.user_id 
            INNER JOIN roles ON roles.id = users.role_id 
            WHERE users.email = ? AND users.password = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param('ss', $email, $password);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $stmt->close();

            if ($row) {
                return new MemberModel(
                    $row['member_id'],
                    $row['contact'],
                    $row['membership_id'],
                    new UserModel(
                        $row['user_id'],
                        $row['email'],
                        $row['name'],
                        new RoleModel($row['role_id'], $row['role_name'])
                    )
                );
            } else {
                return null;
            }
        } else {
            throw new Exception("Failed to prepare statement: " . $conn->error);
        }
    }


}
