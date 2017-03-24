<p class="lef-sidebar-toogle-icon"><a href="#" data-toggle="offcanvas" title="Toogle Sidebar"><i
                class="fa fa-navicon fa-2x"></i></a></p>
<ul class="nav nav-left-sidebar-toogle" id="menu">
    <li>
        <a href="#" data-target="#item1" data-toggle="collapse"><i
                    class="material-icons">note_add</i><span
                    class="collapse in hidden-xs">Add Contact<span class="caret"></span></span></a>
        <ul class="nav nav-stacked collapse left-submenu" id="item1">
            <li><a style="cursor: pointer;" href="{{ route('user.contact.import.choose')}}" class="menu-sub-dropdown"><i class="material-icons">import_contacts</i><span
                            class="collapse in hidden-xs">Import</span></a></li>
            <li><a style="cursor: pointer;" href="{{ route('contact.create')}}" class="menu-sub-dropdown"><i class="material-icons">contact_mail</i> <span
                            class="collapse in hidden-xs">Add Manual</span></a></li>
        </ul>
    </li>
    <li>
        <a href="#" data-target="#item2" data-toggle="collapse"><i
                    class="material-icons">import_export</i><span
                    class="collapse in hidden-xs">Export <span class="caret"></span></span></a>
        <ul class="nav nav-stacked collapse" id="item2">
            <li><a class="menu-sub-dropdown"><i class="material-icons">library_books</i> <span
                            class="collapse in hidden-xs">Export With excel</span></a></li>
            <li><a class="menu-sub-dropdown"><i class="material-icons">bookmark_border</i> <span
                            class="collapse in hidden-xs">Export In Document</span></a></li>
        </ul>
    </li>

    <li>
        <a href="#" data-target="#item3" data-toggle="collapse"><i class="material-icons">import_contacts</i><span
                    class="collapse in hidden-xs">Import<span class="caret"></span></span></a>
        <ul class="nav nav-stacked collapse" id="item3">
            <li><a class="menu-sub-dropdown"><i class="material-icons">import_export</i> <span
                            class="collapse in hidden-xs">Import With excel</span></a></li>
            <li><a class="menu-sub-dropdown"><i class="material-icons">import_contacts</i> <span
                            class="collapse in hidden-xs">Import In Document</span></a></li>
        </ul>
    </li>
    <li class="hide">
        <a href="#" data-target="#item4" data-toggle="collapse"><i class="material-icons">filter</i>
            <span class="collapse in hidden-xs">Filter<span class="caret"></span></span></a>
        <ul class="nav nav-stacked collapse" id="item4">
            <li><a class="menu-sub-dropdown"><i class="material-icons">contact_phone</i> <span
                            class="collapse in hidden-xs">Filter with email</span></a></li>
            <li><a class="menu-sub-dropdown"><i class="material-icons">perm_contact_calendar</i><span
                            class="collapse in hidden-xs">Filter with first name</span></a></li>
        </ul>
    </li>
</ul>

