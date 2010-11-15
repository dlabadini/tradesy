<!-- Menu bar #2. -->
<center>
<div class="menuBar" style="width:80%;"
><a class="menuButton"
    href=""
    onclick="return buttonClick(event, 'fileMenu');"
    onmouseover="buttonMouseover(event, 'fileMenu');"
>Resources</a
><a class="menuButton"
    href=""
    onclick="return buttonClick(event, 'editMenu');"
    onmouseover="buttonMouseover(event, 'editMenu');"
>Documentation</a
><a class="menuButton"
    href=""
    onclick="return buttonClick(event, 'viewMenu');"
    onmouseover="buttonMouseover(event, 'viewMenu');"
>Contacts</a
><a class="menuButton"
    href=""
    onclick="return buttonClick(event, 'toolsMenu');"
    onmouseover="buttonMouseover(event, 'toolsMenu');"
>Tools</a
><a class="menuButton"
    href=""
    onclick="return buttonClick(event, 'optionsMenu');"
    onmouseover="buttonMouseover(event, 'optionsMenu');"
>Options</a
><a class="menuButton"
    href=""
    onclick="return buttonClick(event, 'helpMenu');"
    onmouseover="buttonMouseover(event, 'helpMenu');"
>Account</a
></div>

<!-- Main menus. -->



<!-- Resources Menu. -->
<div id="fileMenu" class="menu"
     onmouseover="menuMouseover(event)">
<a class="menuItem" href="resources/timetable.php">Timesheet</a>
<a class="menuItem" href="blank.html">File Menu Item 3</a>
<a class="menuItem" href="blank.html">File Menu Item 4</a>
<a class="menuItem" href="blank.html">File Menu Item 5</a>
<div class="menuItemSep"></div>
<a class="menuItem" href="blank.html">File Menu Item 6</a>
</div>



<!-- Documentation Menu. -->
<div id="editMenu" class="menu"
     onmouseover="menuMouseover(event)">
<a class="menuItem" href="documentation/project.php">See All</a>
<div class="menuItemSep"></div>
<a class="menuItem" href="documentation/270_271.pdf">270/271</a>
<a class="menuItem" href="documentation/mg.pdf">BusinessWare</a>
<div class="menuItemSep"></div>
<a class="menuItem" href=""
   onclick="return false;"
   onmouseover="menuItemMouseover(event, 'editMenu3');"
><span class="menuItemText">Blank</span><span class="menuItemArrow">&#9654;</span></a>
</div>

<!-- Documentation Sub Menus. -->

<div id="editMenu3" class="menu"
     onmouseover="menuMouseover(event)">
<a class="menuItem" href="blank.html">Edit Menu 3 Item 1</a>
<a class="menuItem" href="blank.html">Edit Menu 3 Item 2</a>
<div class="menuItemSep"></div>
<a class="menuItem" href=""
   onclick="return false;"
   onmouseover="menuItemMouseover(event, 'editMenu3_3');"
><span class="menuItemText">Edit Menu 3 Item 3</span><span class="menuItemArrow">&#9654;</span></a>

<a class="menuItem" href="blank.html">Edit Menu 3 Item 4</a>
</div>

<div id="editMenu3_3" class="menu">
<a class="menuItem" href="blank.html">Edit Menu 3-3 Item 1</a>
<a class="menuItem" href="blank.html">Edit Menu 3-3 Item 2</a>
<a class="menuItem" href="blank.html">Edit Menu 3-3 Item 3</a>
<div class="menuItemSep"></div>
<a class="menuItem" href="blank.html">Edit Menu 3-3 Item 4</a>
</div>


<!-- Contacts Menu. -->
<div id="viewMenu" class="menu">
<a class="menuItem" href="contacts/contacts.php">Co-Workers</a>
<a class="menuItem" href="contacts/customers.php">Customers</a>
<a class="menuItem" href="contacts/government.php">Government</a>
</div>

<!-- Tools Menu. -->
<div id="toolsMenu" class="menu"
     onmouseover="menuMouseover(event)">
<a class="menuItem" href=""
   onclick="return false;"
   onmouseover="menuItemMouseover(event, 'toolsMenu1');"
><span class="menuItemText">Tools Menu Item 1</span><span class="menuItemArrow">&#9654;</span></a>
<a class="menuItem" href="blank.html">Tools Menu Item 2</a>
<a class="menuItem" href="blank.html">Tools Menu Item 3</a>
<div class="menuItemSep"></div>
<a class="menuItem" href=""
   onclick="return false;"
   onmouseover="menuItemMouseover(event, 'toolsMenu4');"
><span class="menuItemText">Tools Menu Item 4</span><span class="menuItemArrow">&#9654;</span></a>
<a class="menuItem" href="blank.html">Tools Menu Item 5</a>
</div>
<!-- Tools sub menus. -->

<div id="toolsMenu1" class="menu">
<a class="menuItem" href="blank.html">Tools Menu 1 Item 1</a>
<a class="menuItem" href="blank.html">Tools Menu 1 Item 2</a>
<div class="menuItemSep"></div>
<a class="menuItem" href="blank.html">Tools Menu 1 Item 3</a>
<a class="menuItem" href="blank.html">Tools Menu 1 Item 4</a>
<div class="menuItemSep"></div>
<a class="menuItem" href="blank.html">Tools Menu 1 Item 5</a>
</div>

<div id="toolsMenu4" class="menu"
     onmouseover="menuMouseover(event)">

<a class="menuItem" href="blank.html">Tools Menu 4 Item 1</a>
<a class="menuItem" href="blank.html">Tools Menu 4 Item 2</a>
<a class="menuItem" href="blank.html"
   onclick="return false;"
   onmouseover="menuItemMouseover(event, 'toolsMenu4_3');"
><span class="menuItemText">Tools Menu 4 Item 3</span><span class="menuItemArrow">&#9654;</span></a>
</div>

<div id="toolsMenu4_3" class="menu">
<a class="menuItem" href="blank.html">Tools Menu 4-3 Item 1</a>
<a class="menuItem" href="blank.html">Tools Menu 4-3 Item 2</a>
<a class="menuItem" href="blank.html">Tools Menu 4-3 Item 3</a>
<a class="menuItem" href="blank.html">Tools Menu 4-3 Item 4</a>

<!-- Options menus. -->
</div>
<div id="optionsMenu" class="menu">
<a class="menuItem" href="/options/1.php">Options Menu Item 1</a>
<a class="menuItem" href="/options/2.php">Options Menu Item 2</a>
<a class="menuItem" href="/options/3.php">Options Menu Item 3</a>
</div>


<!-- Account menus. -->
<div id="helpMenu" class="menu">
<a class="menuItem" href="/account/account.php">My Information</a>
<a class="menuItem" href="/account/help.php">Help</a>
<div class="menuItemSep"></div>
<a class="menuItem" href="/logout.php">Logout</a>
</div>
</center>