<!-- breadcrumb start -->
<div class="breadcrumb_area" style="background-image: url('{{ !empty($imageUri) ? $imageUri : null }}')">
    <div class="breadcrumb_inner d-flex align-items-center">
        <div class="container">
            
            <div class="breadcrumb_custom_content">
                <h1 class="text-bold text-white">{{ page_name() }}</h1>
                {{-- <p class="text-white">{{ page_desc() }}</p> --}}
            </div>
            
        </div>
    </div>
</div>
<!-- breadcrumb end -->