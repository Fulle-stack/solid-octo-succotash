<?php
session_start();

if(!isset($_SESSION["user_id"])){
    header("Location: login.php");
    exit;
}

echo "Вы вошли в систему! <a class='exit_out' href='logout.php'>Выйти</a>"

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">

        <div class="left_block">
            <div class="left_block_one"><img src="admin-img/Brand..svg" alt=""></div>
            <div class="criteria">
                <div class="dashboard"><img class="img_pin" src="admin-img/Home.svg" alt="">
                    <div class="text_img">DASHBOARD</div>
                </div>
                <div class="customers"><img class="img_pin" src="admin-img/Users.svg" alt="">
                    <div class="text_img">CUSTOMERS</div>
                </div>
                <div class="dashboard"><img class="img_pin" src="admin-img/Pie Chart.svg" alt="">
                    <div class="text_img">ANALYTICS</div>
                </div>
            </div>
            <div class="criteria_head">SETTINGS</div>
            <div class="criteria">
                <div class="messages"><img class="img_pin" src="admin-img/Mail.svg" alt="">
                    <div class="text_img">MESSAGES</div>
                </div>
                <div class="messages"><img class="img_pin" src="admin-img/Setting.svg" alt="">
                    <div class="text_img">SETTING</div>
                </div>
                <div class="messages"><img class="img_pin" src="admin-img/Help.svg" alt="">
                    <div class="text_img">HELP CENTRE</div>
                </div>
            </div>
        </div>
        <div class="main_content">
            <div class="main_top">
                <div class="main_nav">
                    <div class="main_nav-item">
                        <div class="bell_pin"><img class="pin_head" src="admin-img/Bell.svg" alt=""></div>
                        <div class="mail-2.0_pin"><img class="pin_head" src="admin-img/Mail-2.0.svg" alt=""></div>
                        <div class="man_pin"><img class="pin_man" src="admin-img/Rectangle 1.svg" alt="">Derek Alvarado
                            <div class="mail-2.0_pin"><img class="pin_chevron" src="admin-img/Chevron Down.svg" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="category-title">
                <div class="category-title_head">Customers’ List</div>
                <div class="category-title_text">
                    <div class="gap_category">
                        <div class="category-1">Dashboard&nbsp;/&nbsp;<span class="black_text">New Customer</span></div>
                        <div class="search-menu">
                            <div class="button-search">
                                <a class="new-customer-btn" href="#"><img src="admin-img/Plus.svg" alt="">NEW
                                    CUSTOMER</a>
                            </div>
                            <div class="search-container">
                                <img src="admin-img/Search.png" alt="" class="search-pin">
                                <input type="text" placeholder="Search..." class="search-input">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table_elemen_color">
                    <table class="table_main">
                        <thead>
                            <tr class="background_gray">
                                <th class="center_simval">#</th>
                                <th>
                                    <div class="header-cell">
                                        <span>Full Name</span>
                                        <div class="icons">
                                            <img src="admin-img/Sort.svg" alt="">
                                            <img src="admin-img/Filter.svg" alt="">
                                        </div>
                                    </div>
                                </th>

                                <th>
                                    <div class="header-cell">
                                        <span>Status</span>
                                        <div class="icons">
                                            <img src="admin-img/Filter.svg" alt="">
                                        </div>
                                    </div>
                                </th>

                                <th>
                                    <div class="header-cell">
                                        <span>E-Mail</span>
                                        <div class="icons">
                                            <img src="admin-img/Sort.svg" alt="">
                                        </div>
                                    </div>
                                </th>

                                <th>
                                    <div class="header-cell">
                                        <span>Date of Birth</span>
                                        <div class="icons">
                                            <img src="admin-img/Sort.svg" alt="">
                                            <img src="admin-img/Filter.svg" alt="">
                                        </div>
                                    </div>
                                </th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="center_simval">1</td>
                                <td>Alyvia Kelley</td>
                                <td>
                                    <div class="status-cell">
                                        <img src="admin-img/Ellipse 1.svg" alt="">
                                        Approved
                                    </div>
                                </td>
                                <td>a.kelley@gmail.com</td>
                                <td>06/18/1978</td>
                                <td>
                                    <img src="admin-img/Button.svg" alt="">
                                    <img src="admin-img/Button-1.svg" alt="">
                                    <img src="admin-img/Button-2.svg" alt="">
                                </td>
                            </tr>
                            <tr class="background_gray">
                                <td class="center_simval">2</td>
                                <td>Jaiden Nixon</td>
                                <td>
                                    <div class="status-cell">
                                        <img src="admin-img/Ellipse 1.svg" alt="">
                                        Approved
                                    </div>
                                </td>
                                <td>jaiden.n@gmail.com</td>
                                <td>09/30/1963</td>
                                <td>
                                    <img src="admin-img/Button.svg" alt="">
                                    <img src="admin-img/Button-1.svg" alt="">
                                    <img src="admin-img/Button-2.svg" alt="">
                                </td>
                            </tr>
                            <tr>
                                <td class="center_simval">3</td>
                                <td>Ace Foley</td>
                                <td>
                                    <div class="status-cell">
                                        <img src="admin-img/Ellipse 1-1.svg" alt="">
                                        Blocked
                                    </div>
                                </td>
                                <td>ace.fo@yahoo.com</td>
                                <td>12/09/1985</td>
                                <td>
                                    <img src="admin-img/Button.svg" alt="">
                                    <img src="admin-img/Button-1.svg" alt="">
                                    <img src="admin-img/Button-2.svg" alt="">
                                </td>
                            </tr>
                            <tr class="background_gray">
                                <td class="center_simval">4</td>
                                <td>Nikolai Schmidt</td>
                                <td>
                                    <div class="status-cell">
                                        <img src="admin-img/Ellipse 1-2.svg" alt="">
                                        Rejected
                                    </div>
                                </td>
                                <td>nikolai.schmidt1964@outlook.com</td>
                                <td>03/22/1956</td>
                                <td>
                                    <img src="admin-img/Button.svg" alt="">
                                    <img src="admin-img/Button-1.svg" alt="">
                                    <img src="admin-img/Button-2.svg" alt="">
                                </td>
                            </tr>
                            <tr>
                                <td class="center_simval">5</td>
                                <td>Clayton Charles</td>
                                <td>
                                    <div class="status-cell">
                                        <img src="admin-img/Ellipse 1.svg" alt="">
                                        Approved
                                    </div>
                                </td>
                                <td>me@clayton.com</td>
                                <td>10/14/1971</td>
                                <td>
                                    <img src="admin-img/Button.svg" alt="">
                                    <img src="admin-img/Button-1.svg" alt="">
                                    <img src="admin-img/Button-2.svg" alt="">
                                </td>
                            </tr>
                            <tr class="background_gray">
                                <td class="center_simval">6</td>
                                <td>Prince Chen</td>
                                <td>
                                    <div class="status-cell">
                                        <img src="admin-img/Ellipse 1.svg" alt="">
                                        Approved
                                    </div>
                                </td>
                                <td>prince.chen1997@gmail.com</td>
                                <td>07/05/1992</td>
                                <td>
                                    <img src="admin-img/Button.svg" alt="">
                                    <img src="admin-img/Button-1.svg" alt="">
                                    <img src="admin-img/Button-2.svg" alt="">
                                </td>
                            </tr>
                            <tr>
                                <td class="center_simval">7</td>
                                <td>Reece Duran</td>
                                <td>
                                    <div class="status-cell">
                                        <img src="admin-img/Ellipse 1.svg" alt="">
                                        Approved
                                    </div>
                                </td>
                                <td>reece@yahoo.com</td>
                                <td>05/26/1980</td>
                                <td>
                                    <img src="admin-img/Button.svg" alt="">
                                    <img src="admin-img/Button-1.svg" alt="">
                                    <img src="admin-img/Button-2.svg" alt="">
                                </td>
                            </tr>
                            <tr class="background_gray">
                                <td class="center_simval">8</td>
                                <td>Anastasia Mcdaniel</td>
                                <td>
                                    <div class="status-cell">
                                        <img src="admin-img/Ellipse 1-2.svg" alt="">
                                        Rejected
                                    </div>
                                </td>
                                <td>anastasia.spring@mcdaniel12.com</td>
                                <td>02/11/1968</td>
                                <td>
                                    <img src="admin-img/Button.svg" alt="">
                                    <img src="admin-img/Button-1.svg" alt="">
                                    <img src="admin-img/Button-2.svg" alt="">
                                </td>
                            </tr>
                            <tr>
                                <td class="center_simval">9</td>
                                <td>Melvin Boyle</td>
                                <td>
                                    <div class="status-cell">
                                        <img src="admin-img/Ellipse 1-1.svg" alt="">
                                        Blocked
                                    </div>
                                </td>
                                <td>Me.boyle@gmail.com</td>
                                <td>08/03/1974</td>
                                <td>
                                    <img src="admin-img/Button.svg" alt="">
                                    <img src="admin-img/Button-1.svg" alt="">
                                    <img src="admin-img/Button-2.svg" alt="">
                                </td>
                            </tr>
                            <tr class="background_gray">
                                <td class="center_simval">10</td>
                                <td>Kailee Thomas</td>
                                <td>
                                    <div class="status-cell">
                                        <img src="admin-img/Ellipse 1-1.svg" alt="">
                                        Blocked
                                    </div>
                                </td>
                                <td>Kailee.thomas@gmail.com</td>
                                <td>11/28/1954</td>
                                <td>
                                    <img src="admin-img/Button.svg" alt="">
                                    <img src="admin-img/Button-1.svg" alt="">
                                    <img src="admin-img/Button-2.svg" alt="">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="gap_space-end">
                        <div class="end_board">
                            <div class="block_arrow">
                                <div class="gray_arrow"><img src="admin-img/Chevron Left.svg" alt=""></div>
                            </div>
                            <div class="while_block-arrow">
                                <div class="while_block-blue">1</div>
                                <div class="while_block">2</div>
                                <div class="while_block">3</div>
                                <div class="while_block">4</div>
                                <div class="while_block_arrow-right"><img src="admin-img/Chevron Right.svg" alt="">
                                </div>
                            </div>
                        </div>
                        <div class="items-per-pag">
                            <select class="select-box">
                                <option>10</option>
                                <option>20</option>
                                <option>30</option>
                            </select>
                            <div class="page_end">/Page</div>
                        </div>
                    </div>

                </div>
                <div class="point_bell"><img src="admin-img/Ellipse 1-2.svg" alt=""></div>
            </div>
        </div>
    </div>
</body>

</html>