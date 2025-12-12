    <?php
      session_start();
      include "../includes/dbConn.php";
      $staffID = null;
      $role = null;
      if(isset($_SESSION['staffID']) && isset($_SESSION['roleOfUser'])){
        $staffID = mysqli_real_escape_string($conn, $_SESSION['staffID']);
        $role = mysqli_real_escape_string($conn, $_SESSION['roleOfUser']);

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



      $title = "Add New FAQ | InkStyle by Dinu";
      $pageTitle = "Add New FAQ";

      include "../includes/admin/adminHeader.php";
      include "../includes/dbConn.php";

      if(isset($_POST['add_faq_btn'])){
        $question = mysqli_real_escape_string($conn, $_POST['question']);
        $answer = mysqli_real_escape_string($conn, $_POST['answer']);


        $addFaqQuery = "INSERT INTO faq(question, answer) VALUES('$question', '$answer')";

        if(mysqli_query($conn, $addFaqQuery)){
            echo '<script>
                   alert("FAQ added successfully!");
                   window.location.href = "./adminPanel.php#admin-inquiries";
                 </script>';
        }
        else{
             echo '<script>
                   alert("Could not add the FAQ!");
                   window.history.back();
                  </script>';
        }
        }
   

    mysqli_close($conn); 
    ?>

        <main class="main-container">
            <div class="form-card">
                <form action="addFAQ.php" method="POST" class="form" >
                    
                    <div class="form-group textarea-group">
                        <label for="question">Question</label>
                        <textarea id="question" name="question" rows="5" required></textarea>
                    </div>

                    <div class="form-group textarea-group">
                        <label for="answer">Answer</label>
                        <textarea id="answer" name="answer" rows="5" required></textarea>
                    </div>
        
                    <div class="form-actions">
                        <button type="submit" class="submit-btn" id="add_faq_btn" name="add_faq_btn"><i class="fa-solid fa-plus-circle"></i> Add FAQ</button>
                        <a href="adminPanel.php#admin-inquiries" class="cancel-btn"><i class="fa-solid fa-xmark-circle"></i> Cancel</a>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <script src="../resources/js/admin/sidebar.js"></script>
</body>
</html>