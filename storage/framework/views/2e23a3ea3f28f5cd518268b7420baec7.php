<?php
  $cats = \App\Models\Category::where('parent_id',null)->where('is_show',1)->where('status','active')->get();
  
  foreach($cats as $cat)
  {
      $childcats = \App\Models\Category::where('parent_id',$cat->id)->where('is_show',1)->where('status','active')->get();
      if(count($childcats)> 0)
        $cat->childcats = $childcats;
  }
  $catblogs = \App\Models\BlogCategory::where('status','active')->get();
?>

<header class="relative wrapper bg-soft-primary !bg-[#edf2fc]">
      <nav class="navbar navbar-expand-lg center-nav navbar-light navbar-bg-light">
        <div class="container xl:flex-row lg:flex-row !flex-nowrap items-center">
          <div class="navbar-brand w-full">
            <a href="<?php echo e(route('home')); ?>">
              <img src="<?php echo e($setting->logo); ?>" srcset="<?php echo e($setting->logo); ?> 2x" alt="image">
            </a>
          </div>
          <div class="navbar-collapse offcanvas offcanvas-nav offcanvas-start">
            <div class="offcanvas-header xl:hidden lg:hidden flex items-center justify-between flex-row p-6">
              <h3 class="text-white xl:text-[1.5rem] !text-[calc(1.275rem_+_0.3vw)] !mb-0"><?php echo e($setting->short_name); ?></h3>
              <button type="button" class="btn-close btn-close-white mr-[-0.75rem] m-0 p-0 leading-none title_color transition-all duration-[0.2s] ease-in-out border-0 motion-reduce:transition-none before:text-[1.05rem] before:content-['\ed3b'] before:w-[1.8rem] before:h-[1.8rem] before:leading-[1.8rem] before:shadow-none before:transition-[background] before:duration-[0.2s] before:ease-in-out before:flex before:justify-center before:items-center before:m-0 before:p-0 before:rounded-[100%] hover:no-underline bg-inherit before:bg-[rgba(255,255,255,.08)] before:font-Unicons hover:before:bg-[rgba(0,0,0,.11)] focus:outline-0" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body xl:!ml-auto lg:!ml-auto flex  flex-col !h-full">
              <ul class="navbar-nav">
                <li class="nav-item ">
                  <a class="nav-link  " href="<?php echo e(route('front.product.hot' )); ?>" >Sản phẩm hot</a>
                </li>
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Danh mục</a>
                  <ul class="dropdown-menu">
                    <?php $__currentLoopData = $cats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <li class=" <?php echo e($cat->childcats != null?'dropdown dropdown-submenu dropend':'nav-item'); ?> ">
                        <a class=" <?php echo e($cat->childcats != null?'dropdown-item dropdown-toggle':'dropdown-item'); ?> " href="<?php echo e(route('front.product.cat',$cat->slug)); ?>" ><?php echo e($cat->title); ?></a>
                        <?php if(isset($cat->childcats) && $cat->childcats != null): ?>
                          <ul class="dropdown-menu">
                            <?php $__currentLoopData = $cat->childcats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $childcat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              <li class="nav-item"><a class="dropdown-item" href="<?php echo e(route('front.product.cat',$childcat->slug)); ?>"><?php echo e($childcat->title); ?></a></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                          </ul>
                        <?php endif; ?>
                      </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </ul>
                </li>
                <li class="nav-item ">
                  <a class="nav-link  " href="<?php echo e(route('front.product.cat','laptop')); ?>" >Laptop</a>
                </li>
                <li class="nav-item ">
                  <a class="nav-link  " href="<?php echo e(route('front.product.cat','camera-wifi')); ?>" >Camera</a>
                </li>
                <li class="nav-item ">
                  <a class="nav-link  " href="<?php echo e(route('front.chinhsach.view','bang-gia')); ?>" >Bảng giá</a>
                </li>
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="<?php echo e(route('front.categories.view' )); ?>"  >Tin tức</a>
                  <?php if(count($catblogs)> 0): ?>
                    <ul class="dropdown-menu">
                      <?php $__currentLoopData = $catblogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $catblog): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="nav-item"><a class="dropdown-item" href="<?php echo e(route('front.category.view',$catblog->slug)); ?>"><?php echo e($catblog->title); ?></a></li>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                  <?php endif; ?>
                </li>
                <li class="nav-item ">
                  <a class="nav-link  " href="<?php echo e(route('front.contact')); ?>" >Liên hệ</a>
                </li>
                 
              </ul>
              <!-- /.navbar-nav -->
              <div class="offcanvas-footer xl:hidden lg:hidden">
                <div>
                  <a href="mailto:first.<?php echo e($setting->email); ?>" class="link-inverse"><?php echo e($setting->email); ?></a>
                  <br> <?php echo e($setting->hotline); ?><br>
                  <nav class="nav social social-white mt-4">
                    <a class="text-[#cacaca] text-[1rem] transition-all duration-[0.2s] ease-in-out translate-y-0 motion-reduce:transition-none hover:translate-y-[-0.15rem] m-[0_.7rem_0_0]" href="<?php echo e($setting->facebook); ?>">
                      <img src="<?php echo e(asset('frontend/assets/images/icon/facenho.png')); ?>" class=" "/>
                    </a>
                    <a class="text-[#cacaca] text-[1rem] transition-all duration-[0.2s] ease-in-out translate-y-0 motion-reduce:transition-none hover:translate-y-[-0.15rem] m-[0_.7rem_0_0]" href="<?php echo e($setting->shopee); ?>">
                      <img src="<?php echo e(asset('frontend/assets/images/icon/shopeenho.png')); ?>" class=" "/>
                    </a>
                    <a class="text-[#cacaca] text-[1rem] transition-all duration-[0.2s] ease-in-out translate-y-0 motion-reduce:transition-none hover:translate-y-[-0.15rem] m-[0_.7rem_0_0]" href="<?php echo e($setting->lazada); ?>">
                      <img src="<?php echo e(asset('frontend/assets/images/icon/laznho.png')); ?>" class=" "/>
                    </a>
                  </nav>
                  <!-- /.social -->
                </div>
              </div>
              <!-- /.offcanvas-footer -->
            </div>
            <!-- /.offcanvas-body -->
          </div>
          <!-- /.navbar-collapse -->
          <div class="navbar-other w-full !flex !ml-auto">
            <ul class="navbar-nav !flex-row !items-center !ml-auto">
              <li class="nav-item"><a class="nav-link" data-bs-toggle="offcanvas" data-bs-target="#offcanvas-search"><i class="uil uil-search before:content-['\eca5'] !text-[1.1rem]"></i></a></li>
              <li class="nav-item"><a class="nav-link" data-bs-toggle="offcanvas" data-bs-target="#offcanvas-user"> <i class="uil uil-user before:content-['\eca5'] !text-[1.1rem]"></i></a></li>
              
              <li class="nav-item ml-[.8rem]">
                <a class="nav-link !relative !flex !flex-row !items-center" data-bs-toggle="offcanvas" data-bs-target="#offcanvas-cart">
                  <i class="uil uil-shopping-cart !text-[1.1rem] before:content-['\ecbd']"></i>
                  <span id="cart_qty_cls" class="badge badge-cart secondarybackgroundcolor w-[0.9rem] h-[0.9rem] !flex items-center justify-center !text-[0.55rem] p-0 rounded-[100%] secondarybackgroundcolor opacity-100"><?php echo e($cart_size); ?></span>
                </a>
              </li>
              <li class="nav-item xl:hidden lg:hidden">
                <button class="hamburger offcanvas-nav-btn"><span></span></button>
              </li>
            </ul>
            <!-- /.navbar-nav -->
          </div>
          <!-- /.navbar-other -->
        </div>
        <!-- /.container -->
      </nav>
      <!-- /.navbar -->
      <div class="offcanvas offcanvas-end bg-light" id="offcanvas-cart" data-bs-scroll="true">
        <div class="offcanvas-header flex items-center justify-between p-[1.5rem]">
          <h3 class="mb-0">Giỏ hàng</h3>
          <button type="button" class="btn-close m-0 p-0 mr-[-.5rem] leading-none title_color transition-all duration-[0.2s] ease-in-out  border-0 motion-reduce:transition-none before:text-[1.05rem] before:content-['\ed3b'] before:w-[1.8rem] before:h-[1.8rem] before:leading-[1.8rem] before:shadow-none before:transition-[background] before:duration-[0.2s] before:ease-in-out before:flex before:justify-center before:items-center before:m-0 before:p-0 before:rounded-[100%] hover:no-underline bg-inherit before:bg-[rgba(0,0,0,.08)] before:font-Unicons hover:before:bg-[rgba(0,0,0,.11)] focus:outline-0
          " data-bs-dismiss="offcanvas" aria-label="Đóng"></button>
        </div>
        <?php echo $__env->make('frontend_tp.layouts.quickcart', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <!-- /.offcanvas-body -->
      </div>
      <!-- /.offcanvas -->
      <div style="width:20rem" class="offcanvas offcanvas-end bg-light" id="offcanvas-user" data-bs-scroll="true">
        <div class="offcanvas-header flex items-center justify-between p-[1.5rem]">
          <h3 class="mb-0"><?php echo e(!$user?'ĐĂNG NHẬP':'THÔNG TIN TÀI KHOẢN'); ?> </h3>
          <button type="button" class="btn-close m-0 p-0 mr-[-.5rem] leading-none title_color transition-all duration-[0.2s] ease-in-out  border-0 motion-reduce:transition-none before:text-[1.05rem] before:content-['\ed3b'] before:w-[1.8rem] before:h-[1.8rem] before:leading-[1.8rem] before:shadow-none before:transition-[background] before:duration-[0.2s] before:ease-in-out before:flex before:justify-center before:items-center before:m-0 before:p-0 before:rounded-[100%] hover:no-underline bg-inherit before:bg-[rgba(0,0,0,.08)] before:font-Unicons hover:before:bg-[rgba(0,0,0,.11)] focus:outline-0
          " data-bs-dismiss="offcanvas" aria-label="Đóng"></button>
      
        </div>
        <?php if(!$user): ?>
          <?php echo $__env->make('frontend_tp.layouts.leftlogin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php else: ?>
          <?php echo $__env->make('frontend_tp.layouts.leftaccount', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php endif; ?>
       
        <!-- /.container -->
      </div>

      <div class="offcanvas offcanvas-top bg-light" id="offcanvas-search" data-bs-scroll="true">
        <div class="container flex !flex-row py-6">
          <form method = "GET" action="<?php echo e(route('front.product.search')); ?>"  class="search-form relative before:content-['\eca5'] before:block before:absolute before:-translate-y-2/4 before:text-[1rem] before:text-[#343f52] before:z-[1] before:right-auto before:top-2/4 before:font-Unicons w-full before:left-0 focus:!outline-offset-0 focus:outline-0">
            <input name="searchdata" placeholder="Tìm kiếm sản phẩm..." id="search-form1" type="text" class="form-control text-[0.8rem] !shadow-none pl-[1.75rem] !pr-[.75rem] border-0 bg-inherit m-0 block w-full font-medium leading-[1.7] text-[#60697b] px-4 py-[0.6rem] rounded-[0.4rem] focus:!outline-offset-0 focus:outline-0" placeholder="Type keyword and hit enter">
          </form> 
          <button type="button" class="btn-close leading-none title_color transition-all duration-[0.2s] ease-in-out p-0 border-0 motion-reduce:transition-none before:text-[1.05rem] before:content-['\ed3b'] before:w-[1.8rem] before:h-[1.8rem] before:leading-[1.8rem] before:shadow-none before:transition-[background] before:duration-[0.2s] before:ease-in-out before:flex before:justify-center before:items-center before:m-0 before:p-0 before:rounded-[100%] hover:no-underline bg-inherit before:bg-[rgba(0,0,0,.08)] before:font-Unicons hover:before:bg-[rgba(0,0,0,.11)] focus:outline-0" data-bs-dismiss="offcanvas" aria-label="Close">

          </button>
        </div>
        <!-- /.container -->
      </div>

      
      <!-- /.offcanvas -->
    </header><?php /**PATH C:\Users\LENOVO\OneDrive\Máy tính\New folder (6)\shoplite-main\resources\views/frontend_tp/layouts/header.blade.php ENDPATH**/ ?>