<?php
require_once 'dbconfig.php';

function validatePhoneNumber($phoneNumber) {
    $phoneNumber = preg_replace('/[^0-9]/', '', $phoneNumber);
    if (strlen($phoneNumber) >= 10) {
        $pattern = '/^(?:\+?88)?\d{10,}$/';
        if (preg_match($pattern, $phoneNumber)) {
            return true;
        }
    }
    return false;
}

function validateEmail($email) {
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return true;
    }
    return false;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['csvFile']) && $_FILES['csvFile']['error'] === UPLOAD_ERR_OK) {
        $filePath = $_FILES['csvFile']['tmp_name'];

        $file = fopen($filePath, 'r');
        if ($file) {
            $insertStmt = $conn->prepare("INSERT INTO users (name, email, phone_number, gender, address) VALUES (:name, :email, :phone, :gender, :address)");
            $deleteStmt = $conn->prepare("DELETE FROM users");
            $deleteStmt->execute();

            $totalData = 0;
            $uploadedCount = 0;
            $duplicateCount = 0;
            $incompleteCount = 0;

            while (($data = fgetcsv($file)) !== false) {
                $totalData++;
                list($name, $email, $phone, $gender, $address) = $data;

                if ($name !== '' && $email !== '' && $phone !== '' && $gender !== '' && $address !== '' &&
                    validatePhoneNumber($phone) && validateEmail($email)
                ) {
                    $duplicateStmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE email = :email OR phone_number = :phone");
                    $duplicateStmt->bindParam(':email', $email);
                    $duplicateStmt->bindParam(':phone', $phone);
                    $duplicateStmt->execute();
                    $duplicateCount = $duplicateStmt->fetchColumn();

                    if ($duplicateCount === 0) {
                        $insertStmt->bindParam(':name', $name);
                        $insertStmt->bindParam(':email', $email);
                        $insertStmt->bindParam(':phone', $phone);
                        $insertStmt->bindParam(':gender', $gender);
                        $insertStmt->bindParam(':address', $address);
                        $insertStmt->execute();
                        $uploadedCount++;
                    } else {
                        $duplicateCount++;
                    }
                } else {
                    $incompleteCount++;
                }
            }

            fclose($file);

            $invalidCount = $totalData - ($uploadedCount + $duplicateCount + $incompleteCount);
            $summary = [
                'Total Data' => $totalData,
                'Total Successfully Uploaded' => $uploadedCount,
                'Total Duplicate' => $duplicateCount,
                'Total Invalid' => $invalidCount,
                'Total Incomplete' => $incompleteCount
            ];

            session_start();
            $_SESSION['summary'] = $summary;

            header("Location: summary.php");
            exit();
        } else {
            die("Failed to open the CSV file.");
        }
    } else {
        die("Error uploading the CSV file.");
    }
} else {
    die("Invalid request method.");
}
?>
