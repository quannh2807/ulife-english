<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <img src="{{ asset('images/user-default.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">Ulife English</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('images/user-default.png') }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">Admin</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link">
                        <i class="nav-icon fas fa-columns"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-circle"></i>
                        <p>
                            Quản trị video
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        {{-- Category video--}}
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fas fa-video nav-icon"></i>
                                <p>
                                    Danh mục video
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.category.index') }}" class="nav-link">
                                        <i class="fas fa-bars nav-icon"></i>
                                        <p>Danh sách</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.category.create') }}" class="nav-link">
                                        <i class="fas fa-plus nav-icon"></i>
                                        <p>Thêm danh mục</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        {{-- Video youtube--}}
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fab fa-youtube nav-icon"></i>
                                <p>
                                    Video
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.video.index') }}" class="nav-link">
                                        <i class="fas fa-bars nav-icon"></i>
                                        <p>Danh sách</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.video.create') }}" class="nav-link">
                                        <i class="fas fa-plus nav-icon"></i>
                                        <p>Thêm video mới</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-question"></i>
                        <p>Quản lý câu hỏi<i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.question.index') }}" class="nav-link">
                                <i class="fas fa-bars nav-icon"></i>
                                <p>Danh sách câu hỏi</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.question.create') }}" class="nav-link">
                                <i class="fas fa-plus nav-icon"></i>
                                <p>Thêm mới câu hỏi</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-file-word"></i>
                        <p>Quản lý Từ vựng<i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.vocabulary.index') }}" class="nav-link">
                                <i class="fas fa-bars nav-icon"></i>
                                <p>Danh sách từ vựng</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.vocabulary.create') }}" class="nav-link">
                                <i class="fas fa-plus nav-icon"></i>
                                <p>Thêm mới từ vựng</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.vocabularyCat.index') }}" class="nav-link">
                                <i class="fas fa-bars nav-icon"></i>
                                <p>Danh mục từ vựng</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.vocabularyCat.create') }}" class="nav-link">
                                <i class="fas fa-plus nav-icon"></i>
                                <p>Thêm mới danh mục</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-tasks"></i>
                        <p>Quản lý Topics<i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.topics.index') }}" class="nav-link">
                                <i class="fas fa-bars nav-icon"></i>
                                <p>Danh sách Topics</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.topics.create') }}" class="nav-link">
                                <i class="fas fa-plus nav-icon"></i>
                                <p>Thêm mới Topics</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-level-up-alt"></i>
                        <p>Quản lý Level<i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.level.index') }}" class="nav-link">
                                <i class="fas fa-bars nav-icon"></i>
                                <p>Danh sách Level</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.level.create') }}" class="nav-link">
                                <i class="fas fa-plus nav-icon"></i>
                                <p>Thêm mới Level</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-chalkboard-teacher"></i>
                        <p>Quản lý Bài học<i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.lesson.index') }}" class="nav-link">
                                <i class="fas fa-bars nav-icon"></i>
                                <p>Danh sách Bài học</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.lesson.create') }}" class="nav-link">
                                <i class="fas fa-plus nav-icon"></i>
                                <p>Thêm mới Bài học</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
