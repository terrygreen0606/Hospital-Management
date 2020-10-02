@extends('layout.master')

@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-body">
        <div class="product-nav-wrapper row">
          <div class="col-lg-4 col-md-5">
            <ul class="nav product-filter-nav">
              <li class="active"><a href="#">BEST SELLERS</a></li>
              <li><a href="#">FEATURED</a></li>
              <li><a href="#">SALES</a></li>
            </ul>
          </div>
          <div class="col-lg-8 col-md-7 product-filter-options">
            <ul class="account-user-info ml-auto">
              <li><a href="#">My Account</a></li>
              <li><a href="#">Wishlist</a></li>
            </ul>
            <ul class="account-user-link d-none d-lg-block">
              <li><a href="#">Login</a></li>
              <li><a href="#">Register</a></li>
            </ul>
            <ul class="account-user-actions">
              <li><a href="#"><i class="mdi mdi-magnify"></i></a></li>
              <li>
                <a href="#"><i class="mdi mdi-cart"></i>
                  <div class="badge badge-pill badge-primary">0</div>
                </a>
              </li>
              <li><a href="#">$0.00</a></li>
            </ul>
          </div>
        </div>
        <div class="row product-item-wrapper">
          <div class="col-lg-4 col-md-6 col-sm-6 col-12 product-item stretch-card">
            <div class="card">
              <div class="card-body">
                <div class="action-holder">
                  <div class="sale-badge bg-success">New</div>
                  <span class="favorite-button"><i class="mdi mdi-heart-outline"></i></span>
                </div>
                <img class="product_image" src="https://via.placeholder.com/288x220" alt="prduct image">
                <p class="product-title">Passion Chair</p>
                <p class="product-price">$399.00</p>
                <p class="product-actual-price">$499.00</p>
                <ul class="product-variation">
                  <li><a href="#">M</a></li>
                  <li><a href="#">L</a></li>
                  <li><a href="#">XL</a></li>
                </ul>
                <p class="product-description">Product Dimensions: Length (13 Inches) Width (13Inches) & Height (30 Inches).</p>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 col-sm-6 col-12 product-item stretch-card">
            <div class="card">
              <div class="card-body">
                <div class="action-holder">
                  <div class="sale-badge bg-success">New</div>
                  <span class="favorite-button"><i class="mdi mdi-heart-outline"></i></span>
                </div>
                <img class="product_image" src="https://via.placeholder.com/288x220" alt="prduct image">
                <p class="product-title">ASIAN Shoes Wonder</p>
                <p class="product-price">$799.00</p>
                <p class="product-actual-price">$899.00</p>
                <ul class="product-variation">
                  <li><a href="#">8</a></li>
                  <li><a href="#">9</a></li>
                  <li><a href="#">10</a></li>
                </ul>
                <p class="product-description">Closure: Lace Up Colour: Grey</p>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 col-sm-6 col-12 product-item stretch-card">
            <div class="card">
              <div class="card-body">
                <div class="action-holder">
                  <div class="sale-badge bg-success">New</div>
                  <span class="favorite-button"><i class="mdi mdi-heart-outline"></i></span>
                </div>
                <img class="product_image" src="https://via.placeholder.com/288x220" alt="prduct image">
                <p class="product-title">Headphones JBL</p>
                <p class="product-price">$199.00</p>
                <p class="product-actual-price">$99.00</p>
                <ul class="product-variation">
                  <li><a href="#">S</a></li>
                  <li><a href="#">M</a></li>
                </ul>
                <p class="product-description">Power Capability: 150mW Cable Length: 1.5 meter</p>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 col-sm-6 col-12 product-item stretch-card">
            <div class="card">
              <div class="card-body">
                <div class="action-holder">
                  <div class="sale-badge bg-success">New</div>
                  <span class="favorite-button"><i class="mdi mdi-heart-outline"></i></span>
                </div>
                <img class="product_image" src="https://via.placeholder.com/288x220" alt="prduct image">
                <p class="product-title">Nike Runallday</p>
                <p class="product-price">$745.00</p>
                <p class="product-actual-price">$845.00</p>
                <ul class="product-variation">
                  <li><a href="#">7</a></li>
                  <li><a href="#">8</a></li>
                  <li><a href="#">9</a></li>
                </ul>
                <p class="product-description">Material: Other<br> Product Type: Sports Shoe</p>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 col-sm-6 col-12 product-item stretch-card">
            <div class="card">
              <div class="card-body">
                <div class="action-holder">
                  <div class="sale-badge bg-success">New</div>
                  <span class="favorite-button"><i class="mdi mdi-heart-outline"></i></span>
                </div>
                <img class="product_image" src="https://via.placeholder.com/288x220" alt="prduct image">
                <p class="product-title">Puma shoe</p>
                <p class="product-price">$799.00</p>
                <p class="product-actual-price">$899.00</p>
                <ul class="product-variation">
                  <li><a href="#">8</a></li>
                  <li><a href="#">9</a></li>
                  <li><a href="#">10</a></li>
                </ul>
                <p class="product-description">Material Type: Textile<br> Lifestyle: Sports</p>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 col-sm-6 col-12 product-item stretch-card">
            <div class="card">
              <div class="card-body">
                <div class="action-holder">
                  <div class="sale-badge bg-success">New</div>
                  <span class="favorite-button"><i class="mdi mdi-heart-outline"></i></span>
                </div>
                <img class="product_image" src="https://via.placeholder.com/288x220" alt="prduct image">
                <p class="product-title">Fastrack UV</p>
                <p class="product-price">$129.00</p>
                <p class="product-actual-price">$199.00</p>
                <ul class="product-variation">
                  <li><a href="#">Black</a></li>
                  <li><a href="#">Brown</a></li>
                </ul>
                <p class="product-description">Frame size: Lens Length = 16 cm<br> Width = 8.1 cm,Height = 5.6 cm </p>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 col-sm-6 col-12 product-item stretch-card">
            <div class="card">
              <div class="card-body">
                <div class="action-holder">
                  <div class="sale-badge bg-success">New</div>
                  <span class="favorite-button"><i class="mdi mdi-heart-outline"></i></span>
                </div>
                <img class="product_image" src="https://via.placeholder.com/288x220" alt="prduct image">
                <p class="product-title">Tryfeet Shoe</p>
                <p class="product-price">$329.00</p>
                <p class="product-actual-price">$499.00</p>
                <ul class="product-variation">
                  <li><a href="#">M</a></li>
                  <li><a href="#">L</a></li>
                  <li><a href="#">XL</a></li>
                </ul>
                <p class="product-description">Product Dimensions: Length (13 Inches) Width (13Inches) & Height (30 Inches).</p>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 col-sm-6 col-12 product-item stretch-card">
            <div class="card">
              <div class="card-body">
                <div class="action-holder">
                  <div class="sale-badge bg-success">New</div>
                  <span class="favorite-button"><i class="mdi mdi-heart-outline"></i></span>
                </div>
                <img class="product_image" src="https://via.placeholder.com/288x220" alt="prduct image">
                <p class="product-title">Jacques Lemans Watch</p>
                <p class="product-price">$289.00</p>
                <p class="product-actual-price">$499.00</p>
                <ul class="product-variation">
                  <li><a href="#">M</a></li>
                  <li><a href="#">L</a></li>
                  <li><a href="#">XL</a></li>
                </ul>
                <p class="product-description">Product Dimensions: Length (13 Inches) Width (13Inches) & Height (30 Inches).</p>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 col-sm-6 col-12 product-item stretch-card">
            <div class="card">
              <div class="card-body">
                <div class="action-holder">
                  <div class="sale-badge bg-success">New</div>
                  <span class="favorite-button"><i class="mdi mdi-heart-outline"></i></span>
                </div>
                <img class="product_image" src="https://via.placeholder.com/288x220" alt="prduct image">
                <p class="product-title">American Tourister</p>
                <p class="product-price">$399.00</p>
                <p class="product-actual-price">$499.00</p>
                <ul class="product-variation">
                  <li><a href="#">M</a></li>
                  <li><a href="#">L</a></li>
                  <li><a href="#">XL</a></li>
                </ul>
                <p class="product-description">Product Dimensions: Length (13 Inches) Width (13Inches) & Height (30 Inches).</p>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 col-sm-6 col-12 product-item stretch-card">
            <div class="card">
              <div class="card-body">
                <div class="action-holder">
                  <div class="sale-badge bg-success">New</div>
                  <span class="favorite-button"><i class="mdi mdi-heart-outline"></i></span>
                </div>
                <img class="product_image" src="https://via.placeholder.com/288x220" alt="prduct image">
                <p class="product-title">Women Handbag</p>
                <p class="product-price">$299.00</p>
                <p class="product-actual-price">$300.00</p>
                <ul class="product-variation">
                  <li><a href="#">Black</a></li>
                  <li><a href="#">Pink</a></li>
                </ul>
                <p class="product-description">Sole: Other<br> Closure: Slip On</p>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 col-sm-6 col-12 product-item stretch-card">
            <div class="card">
              <div class="card-body">
                <div class="action-holder">
                  <div class="sale-badge bg-success">New</div>
                  <span class="favorite-button"><i class="mdi mdi-heart-outline"></i></span>
                </div>
                <img class="product_image" src="https://via.placeholder.com/288x220" alt="prduct image">
                <p class="product-title">Plastic Wall Clock</p>
                <p class="product-price">$99.00</p>
                <p class="product-actual-price">$199.00</p>
                <ul class="product-variation">
                  <li><a href="#">S</a></li>
                  <li><a href="#">M</a></li>
                </ul>
                <p class="product-description">Dial Colour:Black<br> Strap Colour:Brown </p>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 col-sm-6 col-12 product-item stretch-card">
            <div class="card">
              <div class="card-body">
                <div class="action-holder">
                  <div class="sale-badge bg-success">New</div>
                  <span class="favorite-button"><i class="mdi mdi-heart-outline"></i></span>
                </div>
                <img class="product_image" src="https://via.placeholder.com/288x220" alt="prduct image">
                <p class="product-title">IPhone X</p>
                <p class="product-price">$999.00</p>
                <p class="product-actual-price">$1999.00</p>
                <ul class="product-variation">
                  <li><a href="#">128</a></li>
                  <li><a href="#">256</a></li>
                </ul>
                <p class="product-description">5.8-inch Super Retina display<br> Wireless charging</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection