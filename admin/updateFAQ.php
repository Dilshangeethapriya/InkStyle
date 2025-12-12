    <?php
     session_start();
     include "../includes/dbConn.php";
     $staffID = null;
     $role = null;
     if(isset($_SESSION['staffID']) && isset($_SESSION['roleOfUser'])){
       $staffID = mysqli_real_escape_string($conn, $_SESSION['staffID']);
       $role = mysqli_real_escape_string($conn, $_SESSION['roleOfUser']);
        //
       // ---- for admin only pages  ----
       if($role !== 'Admin'){
           echo '<script>
                  alert("You dont have access to this page!");
                  window.location.href = "./adminPanel.php";
                </script>';
          exit();
       }
     }
     else{
      header("Location: staffLogin.php");
      exit();
     }
      
      $title = "Update FAQ | InkStyle by Dinu";
      $pageTitle = "Update FAQ";

      include "../includes/admin/adminHeader.php";
    

      $faqID = null;
      $faqData = null;
      if(isset($_GET['faqID'])){
          $faqID = mysqli_real_escape_string($conn, $_GET['faqID']);

          $fetchFaqDataQuery = "SELECT * FROM faq WHERE faqID = '$faqID'";
          $fetchFaqDataResult = mysqli_query($conn, $fetchFaqDataQuery);

          if(mysqli_num_rows($fetchFaqDataResult) === 1){
            $faqData = mysqli_fetch_assoc($fetchFaqDataResult);
         }
        else{
        echo '<div class="status-message" style="position: absolute; width: 100%; top: 100px; color:red" ><p>FAQ data is not found!</p></div>';
            exit();
        }
        }
      else{
          echo '<div class="status-message" style="position: absolute; width: 100%; top: 100px; color:red"><p>FAQ ID is not provided!</p></div>';
          exit();
      }




      if(isset($_POST['update_faq_btn'])){
        $question = mysqli_real_escape_string($conn, $_POST['question']);
        $answer = mysqli_real_escape_string($conn, $_POST['answer']);


        $updateFaqQuery = "UPDATE faq SET question = '$question', answer = '$answer' WHERE faqID = '$faqID'";

        if(mysqli_query($conn, $updateFaqQuery)){
            echo '<script>
                   alert("FAQ updated successfully!");
                   window.location.href = "./adminPanel.php#admin-inquiries";
                 </script>';
        }
        else{
             echo '<script>
                   alert("Could not update the FAQ!");
                   window.history.back();
                  </script>';
        }
        }
   

    mysqli_close($conn); 
    ?>

        <main class="main-container">
            <div class="form-card">
                <form action="updateFAQ.php?faqID=<?php echo htmlspecialchars($faqData['faqID']); ?>" method="POST" class="form" >
                    
                    <div class="form-group textarea-group">
                        <label for="question">Question</label>
                        <textarea id="question" name="question" rows="5" required><?php echo htmlspecialchars($faqData['question']); ?></textarea>
                    </div>

                    <div class="form-group textarea-group">
                        <label for="answer">Answer</label>
                        <textarea id="answer" name="answer" rows="5" required><?php echo htmlspecialchars($faqData['answer']); ?></textarea>
                    </div>
        
                    <div class="form-actions">
                        <button type="submit" class="submit-btn" id="update_faq_btn" name="update_faq_btn"><i class="fa-solid fa-pen-to-square"></i> Update FAQ</button>
                        <a href="adminPanel.php#admin-inquiries" class="cancel-btn"><i class="fa-solid fa-xmark-circle"></i> Cancel</a>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <script src="../resources/js/admin/sidebar.js"></script>
</body>
</html>