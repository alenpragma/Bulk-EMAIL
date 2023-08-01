
  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('home') }}" class="brand-link">
      <h5 class="brand-text font-weight-light text-center"><b>Dashboard</b></h5>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar Menu -->
      <nav>
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item text-center">
            <a href="{{ route('home') }}" class="nav-link">
              <p>
                @php
    use Illuminate\Support\Facades\Auth;
@endphp
             @php
                 $limit = App\Models\User::where('id',auth::user()->id)->first();
             @endphp
                 
                 Your Limit {{$limit->limit}}  
                
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('insert_leads') }}" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Insert Leads
              </p>
            </a>
          </li>


          @if(auth()->user()->type==1)
            <li class="nav-item">
              <a href="{{ route('regular_smtp') }}" class="nav-link">
                <i class="nav-icon fas fa-envelope"></i>
                <p>
                  SMTP List
                </p>
              </a>
            </li>
            @endif
         
            <li class="nav-item">
                <a href="{{ route('message.create') }}" class="nav-link">
                  <i class="nav-icon fas fa-chart-pie"></i>
                  <p>
                    Message
                  </p>
                </a>
            </li>

            <li class="nav-item">
              <a href="{{ route('Campaign_Name') }}" class="nav-link">
                <i class="nav-icon fas fa-chart-pie"></i>
                <p>
                  Campaign Name
                </p>
              </a>
          </li>

          <li class="nav-item">
            <a href="{{ route('ReplyTo') }}" class="nav-link">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
                ReplyTo
              </p>
            </a>
        </li>

          @if(auth()->user()->type==1)
            <li class="nav-item">
              <a href="{{ route('users') }}" class="nav-link">
                <i class="nav-icon fas fa-chart-pie"></i>
                <p>
                  User
                </p>
              </a>
          </li>

            </li>
            @endif

            <li class="nav-item">
              <a href="change-password" class="nav-link">
                <i class="nav-icon fas fa-chart-pie"></i>
                <p>
                  Change Password
                </p>
              </a>
          </li>

        </ul>

        
      </nav>
    
      
      
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>