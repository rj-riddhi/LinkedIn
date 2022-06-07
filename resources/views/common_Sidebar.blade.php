<nav id="sidebar">
            <div class="sidebar-header">
                <h3><img src='https://cdn4.iconfinder.com/data/icons/social-icon-4/842/linkedin-512.png' class="img-fluid"/><span>{{session()->get('UsersName')}}</span></h3>
            </div>
            <ul class="list-unstyled components">
			<li id="dashli">
                    <a href="/Dashboard" class="dashboard"><i class="material-icons">dashboard</i><span>Dashboard</span></a>
            </li>
		
		      <div class="small-screen navbar-display">
                <li class="dropdown d-lg-none d-md-block d-xl-none d-sm-block">
                    <a href="#homeSubmenu0" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
					<i class="material-icons">notifications</i><span> 4 notification</span></a>
                    <ul class="collapse list-unstyled menu" id="homeSubmenu0">
                                    <li>
                                    <a href="#">You have 5 new messages</a>
                                    </li>
                                    
                    </ul>
                </li>
				<li class="dropdown d-lg-none d-md-block d-xl-none d-sm-block">
                    <a href="#settings" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
					<i class="material-icons">person</i><span>user</span></a>
                    <ul class="collapse list-unstyled menu" id="settings">
                                    <li>
                                    <a href="/logout"><i class="material-icons">logout</i><span>Log Out</span></a>
                                    <a href="#"><i class="material-icons">settings</i><span>Settings</span></a>
                                    </li>
                     </ul>
                </li>
			  </div>
			
				<li class="dropdown" id="chartli">
                    <a href="#pageSubmenu3" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
					<i class="material-icons">equalizer</i><span>chart</span>
                    </a>
				     
                    <ul class="collapse list-unstyled menu" id="pageSubmenu3">
                                    <li class="active" id="pieli">
                                        <a href="/charts" onclick="piechartload()" style="cursor:pointer"><i class="material-icons">pie_chart</i>Registrations</a>
                                    </li>
                                    <li class="" id="barli">
                                        <a onclick="barchartload()" style="cursor:pointer"><i class="material-icons">bar_chart</i>User Logs</a>
                                    </li>
                    </ul>
                </li>
				
               <li  class="" id="actli">
                    <a href="/Activity"><i class="material-icons">date_range</i><span>Activity Log</span></a>
               </li>
				
			   <li  class="" id="calli">
                    <a href="#"><i class="material-icons">library_books</i><span>Calender</span></a>
               </li>
               
               
            </ul>

           
        </nav>
		
		

        <!-- Page Content  -->
        <div id="content">
		
		<div class="top-navbar">
            <nav class="navbar navbar-expand-lg">
                <div class="container-fluid">

                    <button type="button" id="sidebarCollapse" class="d-xl-block d-lg-block d-md-mone d-none">
                        <span class="material-icons">arrow_back_ios</span>
                    </button>
					
					<a class="navbar-brand" href="/Dashboard"> Dashboard </a>
					
                    <button class="d-inline-block d-lg-none ml-auto more-button" type="button"              data-toggle="collapse"
					data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="material-icons">more_vert</span>
                    </button>

                    <div class="collapse navbar-collapse d-lg-block d-xl-block d-sm-none d-md-none     d-none"    id="navbarSupportedContent">
                        <ul class="nav navbar-nav ml-auto">   
                            <li class="dropdown ">
                                <a href="#" class="nav-link" data-toggle="dropdown">
                                   <span class="material-icons">notifications</span>
								   <span class="notification">1</span>
                               </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="#">You have 5 new messages</a>
                                    </li>
                                  
                                </ul>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link" data-toggle="dropdown" href="#">
								<span class="material-icons">person</span>
								</a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="/logout">Log Out</a>
                                        <a href="#">Settings</a>
                                    </li>
                                </ul>
                            </li>
							
                        </ul>
                    </div>
                </div>
            </nav>
	    </div>