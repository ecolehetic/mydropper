<body>
    <header>
        <input id="searchBar" type="text" placeholder="Search" />
        <div class="headerContent">HENG Patrick</div>
        <div id="profile">
            <img src="../assets/images/incognito.jpg" alt="Profile picture">
            <ul id="profileMenu">
                <li><a href="#">Settings</a></li>
                <li><a href="#">Log out</a></li>
            </ul>
        </div>
    </header>


    <div id="burger">
        <div id="row1"></div>
        <div id="row2"></div>
        <div id="row3"></div>
    </div>

    <!-- Flash messages -->
    <ul id="flashMsg">
        <li class="animated fadeInRight error">Snippet Added</li>
        <li class="animated fadeInRight alert">Doesnt Work, Nononono nononono it doeesnt</li>
        <li class="animated fadeInRight">Doesnt Work, Nononono nononono it doeesnt</li>
    </ul
    <!-- Popin for add category and snippets -->
    <div id="popin">
        <div id="popinBg" class="animated fadeIn">
        </div>
        <div id="addCategoryFormContainer" class="popinContent animated zoomIn">
            <div id="closePopin"><i class="icon-close"></i></div>
            <h2>Add a category</h2>
            <form action="" class="formData" id="addCategoryForm">
                <div class="form-group">
                    <label for="dataName">Name :</label>
                    <input type="text" name="dataName" placeholder="dataName" required/>
                </div>

                <div class="form-group">
                    <input type="submit" class="hidden" value="addData"/>
                    <a href="#" id="submitEdit" class="ghostBtn submitBtn clearfix animated fadeInRight">
                        <span>Validate</span>
                    </a>
                </div>
            </form>
        </div>

        <div id="addSnippetFormContainer" class="popinContent animated zoomIn">
            <div id="closePopin"><i class="icon-close"></i></div>
            <h2>Add a snippet</h2>
            <form action="" class="formData" id="addSnippetForm">
                <div class="form-group">
                    <label for="dataName">Name :</label>
                    <input type="text" name="dataName" placeholder="dataName" required/>
                </div>
                <div class="form-group">
                    <label for="content">Content :</label>
                    <textarea name="content" form="addSnippetForm" placeholder="Enter your snippet content here ..."></textarea>
                </div>
                <div class="form-group disabled" id="urlCheckbox">
                    <input type="checkbox" value="trackedLink" disabled> I want my link shortered and tracked.<br>
                </div>
                <input type="hidden" id="categoryID" value="">
                <div class="form-group">
                    <input type="submit" class="hidden" value="addData"/>
                    <a href="#" id="submitEdit" class="ghostBtn submitBtn clearfix animated fadeInRight">
                        <span>Validate</span>
                    </a>
                </div>
            </form>
        </div>
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

                <li>
                    <ul id="categoryList">
                        <li class="categoryElement">
                            <a href="#" class="categoryName"><i class="icon-folder"></i> Category</a>
                            <span>+</span>
                            <ul class="snippetsList">
                                <li>
                                    <a href="{{ url('/store/add') }}" class="addSnippetLink" data-id="123"><i class="icon-plus"></i>Add a snippet</a>
                                </li>
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
                                <li>
                                    <a href="{{ url('/store/add') }}" class="addSnippetLink" data-id="456"><i class="icon-plus"></i>Add a snippet</a>
                                </li>
                                <li><a href="#"><i class="icon-tag"></i> Snipet TEST 1</a>
                                </li>
                                <li><a href="#"><i class="icon-tag"></i> Snipet TEST 2</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
            </ul>
            <a href="#" class="button" id="addCategory">
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