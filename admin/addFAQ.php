    <?php
      session_start();
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
                        <a href="./adminPanel.php#admin-inquiries"><button type="button" class="cancel-btn"><i class="fa-solid fa-xmark-circle"></i> Cancel</button></a>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <script src="../resources/js/admin/sidebar.js"></script>
</body>
</html>