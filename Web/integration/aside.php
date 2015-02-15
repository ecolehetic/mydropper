<body>
    <header>
        <input id="searchBar" type="text" placeholder="Search" />
        <div class="headerContent clearfix">HENG Patrick</div>
        <div id="profile">
            <img src="../assets/images/incognito.jpg" alt="Profile picture">
            <ul id="profileMenu">
                <li>Settings</li>
                <li>Log out</li>
            </ul>
        </div>
    </header>

    <!-- LEFT PART -->
    <div id="burger">
        <div id="row1"></div>
        <div id="row2"></div>
        <div id="row3"></div>
    </div>

    <div id="sideBar">
        <nav>
            <ul id="menu">
                <li class="menuLink active" id="dashboardLink">
                    <a href="#"><i class="icon-dashboard"></i> Dashboard</a>
                </li>

                <li class="menuLink" id="trackingLink">
                    <a href="#"><i class="icon-tracking"></i> Tracking</a>
                </li>

                <li class="menuLink" id="settingsLink">
                    <a href="#"><i class="icon-settings"></i> Settings</a>
                </li>

                <li>
                    <ul id="categoryList">
                        <li class="categoryElement">
                            <a href="#" class="categoryName"><i class="icon-folder"></i> Category</a>
                            <span>+</span>
                            <ul class="snippetsList">
                                <li><a href="#"><i class="icon-tag"></i> Snipet 1</a>
                                </li>
                                <li><a href="#"><i class="icon-tag"></i> Snipet 2</a>
                                </li>
                            </ul>
                        </li>
                        <li class="categoryElement">
                            <a href="#" class="categoryName"><i class="icon-folder"></i> Category Name 2</a>
                            <span>+</span>
                            <ul class="snippetsList">
                                <li><a href="#"><i class="icon-tag"></i> Snipet TEST 1</a>
                                </li>
                                <li><a href="#"><i class="icon-tag"></i> Snipet TEST 2</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
            </ul>
            <a href="#" class="button">
                <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%">
                    <line class="top" x1="0" y1="0" x2="465" y2="0" />
                    <line class="left" x1="0" y1="50" x2="0" y2="-100" />
                    <line class="bottom" x1="155" y1="50" x2="-310" y2="50" />
                    <line class="right" x1="155" y1="0" x2="155" y2="150" />
                </svg>
                <span>Add a category</span>
            </a>
        </nav>
    </div>