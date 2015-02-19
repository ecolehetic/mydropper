<?php include('header.php'); ?>
<?php include('aside.php'); ?>

    <!-- MAIN CONTENT -->
    <div class="container">
        <div id="tracking">
            <h1>Tracking</h1>
            <ul id="tabs">
                <li class="selected">Category 1</li><li>
                    Patrick 2
                </li><li>
                    Mongolyto 2
                </li><li>
                    SahshaetPikachu 2
                </li><li>
                    Mes impots
                </li><li>
                    Lettres de motivation
                </li><li>
                    Yoyoyoyouoyo 2
                </li><li>
                    Category 2
                </li><li>
                    Category 3
                </li>
            </ul>
            <!--<div id="line-graph" class="line-graph"></div>-->

            <div class="categoryGraphContainer clearfix">
                <div class="deltaGraphContainer">
                    <div class="inputGroup">
                        <label>From : </label>
                        <input type="date" id="from"/>
                    </div>
                    <div class="inputGroup">
                        <label>To : </label>
                        <input type="date" id="from"/>
                    </div>
                </div>
                <div class="categoryGraph ct-chart">
                </div>
            </div>


            <ul id="snippetGraphList">
                <li>
                    <div class="snippetDetails">
                        <h2>Snippets 1</h2>
                        <p>Create at 12/02/2015</p>
                    </div>

                    <div class="clickRateGraphContainer">
                        <div class="clickRateGraph ct-chart .ct-square"></div>
                        <span>Click rate</span>
                    </div>


                    <div class="snippetGraphContainer">
                        <div class="snippetGraph ct-chart"></div>
                    </div>
                </li>
            </ul>
        </div>
    </div>

<?php include('footer.php'); ?>