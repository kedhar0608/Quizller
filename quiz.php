<?php
    include 'database/config.php';
    session_start();

    if(!isset($_SESSION['test_id']))
        header("Location: index.php");
    else
        $_SESSION['test_ongoing'] = "true";
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Quizller- Quiz</title>
        <link rel="icon" type="image/png" href="admin/assets/img/favicon.png">
        <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="css/header.css">
        <link rel="stylesheet" type="text/css" href="css/util.css">
        <link rel="stylesheet" type="text/css" href="css/main.css">
        <link rel="stylesheet" type="text/css" href="css/quiz.css">
        <script src="vendor/jquery/jquery-3.2.1.min.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
        <script src="vendor/tilt/tilt.jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/js-cookie@beta/dist/js.cookie.min.js"></script>
    </head>
    <body>
    <header class="header1">
            <!-- Header desktop -->
            <div class="container-menu-header">
                <div class="wrap_header">
                    <!-- Logo -->
                    <a href="index.html" class="logo">
                        <img src="images/icons/logo.png" alt="IMG-LOGO">
                    </a>

                    <!-- Header Icon -->
                    <div class="header-icons">
                        <a href="#" class="header-wrapicon1 dis-block">
                            <img src="images/icons/logout.png" class="header-icon1" alt="ICON" onclick = 'logout()'>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Header Mobile -->
            <div class="wrap_header_mobile">
                <!-- Logo moblie -->
                <a href="index.html" class="logo-mobile">
                    <img src="images/icons/logo.png" alt="IMG-LOGO">
                </a>

                <!-- Button show menu -->
                <div class="btn-show-menu">
                    <!-- Header Icon mobile -->
                    <div class="header-icons-mobile">
                        <a href="#" class="header-wrapicon1 dis-block">
                            <img src="images/icons/icon-header-01.png" class="header-icon1" alt="ICON">
                        </a>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <section>
            <div class="limiter">
                <div class="container-login100" style="display:block;">
                    <div class="container">
                        <div class="row">
                            <div class="col" style="padding:0px;">
                                    <div class="card" style="padding-bottom: 20px;">
                                        <div class="container">
                                                <div class="row">
                                                    <div class="col-md-12" style="padding:0px;">
                                                        <div class="container-fluid">
                                                            <div class="modal-dialog" style="max-width: 100%">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5><span class="label label-warning" id="qid">1</span> <span id="question">Which framework is used for native app development</span></h5>
                                                                </div>
                                                                <div class="modal-body">
                                                                <div class="col-xs-3 col-xs-offset-5">
                                                                </div>

                                                                <div class="quiz" id="quiz" data-toggle="buttons">
                                                                <label id="optionA" onclick="getSelectedItem('a')" class="element-animation1 btn btn-lg btn-primary btn-block"><span class="btn-label" ><i class="glyphicon glyphicon-chevron-right"></i></span> <input type="radio" name="q_answer" value="1" onclick="alert('Jp')">1. Ionic</label>
                                                                <label id="optionB" onclick="getSelectedItem('b')" class="element-animation2 btn btn-lg btn-primary btn-block"><span class="btn-label"><i class="glyphicon glyphicon-chevron-right"></i></span> <input type="radio" name="q_answer" value="2">2. Django</label>
                                                                <label id="optionC" onclick="getSelectedItem('c')" class="element-animation3 btn btn-lg btn-primary btn-block"><span class="btn-label"><i class="glyphicon glyphicon-chevron-right"></i></span> <input type="radio" name="q_answer" value="3">3. Laravel</label>
                                                                <label id="optionD" onclick="getSelectedItem('d')" class="element-animation4 btn btn-lg btn-primary btn-block"><span class="btn-label"><i class="glyphicon glyphicon-chevron-right"></i></span> <input type="radio" name="q_answer" value="4">4. Pandas</label>
                                                            </div>
                                                            </div>
                                                        </div>
                                                        </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <script>
            var question_data;
            $(document).ready(function(){
                if(Cookies.get('last_question_was_answered') == undefined || Cookies.get('last_question_was_answered') == "true"){
                    createQuestion();
                    Cookies.set('last_question_was_answered', 'false')
                }else if (Cookies.get('last_question_was_answered') == "false"){
                    //load previous question,dont fire ajax request
                    alert("Will load previous question");
                    loadQuestion(JSON.parse(Cookies.get('last_question')));
                    question_data = JSON.parse(Cookies.get('last_question'))
                }      
            });
        
            $('.js-tilt').tilt({
                scale: 1.1
            })	

            function getSelectedItem(val){
                Cookies.set('last_question_was_answered', 'true')
                
                /*if(val == question_data.correctAns){        //Correct Answer
                    $.ajax({
                        type: 'POST',
                        url: 'increment_score_and_correct_count.php',
                        data: { 
                            'score': question_data.score.toString(),
                            'question_id' : question_data.id.toString() 
                        },
                        success: function(msg){
                            //alert(msg);
                            createQuestion();
                        }
                    });
                }else{                  //Wrong Answer
                    $.ajax({
                        type: 'POST',
                        url: 'increment_wrong_count.php',
                        data: { 
                            'question_id' : question_data.id.toString() 
                        },
                        success: function(msg){
                            //alert(msg);
                            createQuestion();
                        }
                    });
                }*/

                $.ajax({
                type : 'POST',
                url: "check_answer.php",
                data : {'question_id' : question_data.id.toString(), 
                        'selected_option' : val.toString(),
                        'score' : question_data.score.toString()
                },
                success: function(result){
                   createQuestion();
                }});
            }

            function createQuestion(){
                $.ajax({url: "get_question.php", success: function(result){
                    if(result === "QUESTION_SET_FINISHED"){
                        $.ajax({
                            type: 'POST',
                            url: 'end_session.php',
                            data: { 
                                'message': '0',
                            },
                            success: function(msg){
                                alert(msg);
                                Cookies.remove('last_question_was_answered');
                                Cookies.remove('last_question');
                                Cookies.set('test_submitted_status', msg.toString());
                                window.location.replace("test_finished.php");
                            }
                        });
                    }else{
                        question_data = JSON.parse(result);
                        Cookies.set('last_question', result)
                        Cookies.set('last_question_was_answered', "false")
                        loadQuestion(question_data);
                    }
                }});
            }

            function loadQuestion(question_data){
                $('#qid').text(question_data.id);
                $('#question').text(question_data.title);
                $('#optionA').text(question_data.optionA);
                $('#optionB').text(question_data.optionB);
                $('#optionC').text(question_data.optionC);
                $('#optionD').text(question_data.optionD);
            }

            function logout(){
                $.ajax({
                        type: 'POST',
                        url: 'end_session.php',
                        data: { 
                            'message': '1',
                        },
                        success: function(msg){
                            alert(msg);
                            Cookies.remove('last_question_was_answered');
                            Cookies.remove('last_question');
                            Cookies.set('test_submitted_status', msg.toString());
                            window.location.replace("test_finished.php");
                        }
                });
            }

            window.onclose = closing;

        function closing(){
            alert("Closing");
        }
        </script>
    </body>
</html>