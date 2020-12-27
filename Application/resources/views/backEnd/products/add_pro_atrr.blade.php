@extends('backEnd.layouts.master')
@section('title','Add Attribute')
@section('content')
    <div id="breadcrumb"> <a href="{{url('/admin')}}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Accueil</a> <a href="{{route('product.index')}}">Produits</a> <a href="#" class="current">Ajouter Attribut</a> </div>
    <div class="container-fluid">
        @if(Session::has('message'))
            <div class="alert alert-success text-center" role="alert">
                <strong>Bien joué! &nbsp;</strong>{{Session::get('message')}}
            </div>
        @endif
            <div class="row-fluid">
                <div class="span6">
                    <div class="widget-box">
                        <div class="widget-title"> <span class="icon"> <i class="icon-file"></i> </span>
                            <h5>Produit : {{$product->p_name}}</h5>
                        </div>
                        <div class="widget-content nopadding">
                            <ul class="recent-posts">
                                <li>
                                    <div class="user-thumb"> <img width="40" height="40" alt="User" src="{{url('products/small',$product->image)}}"> </div>
                                    <div class="article-post">
                                        <span class="user-info">Produit Code : <b>{{$product->p_code}}</b></span>
                                        <p>Couleur du Produit: <b>{{$product->p_color}}</b></p>
                                    </div>
                                </li>
                                <li>
                                    <form action="{{route('product_attr.store')}}" method="post" role="form">
                                        <legend>Ajouter Attribut</legend>
                                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                                        <div class="form-group">
                                            <input type="hidden" name="products_id" value="{{$product->id}}">
                                            <input type="text" class="form-control" name="sku" value="{{old('sku')}}" id="sku" placeholder="Couleur" required>
                                            <input type="text" class="form-control" name="size" value="{{old('size')}}" id="size" placeholder="Taille" required>
                                            <input type="text" class="form-control" name="prix" value="{{old('price')}}" id="price" placeholder="prix" required>
                                            <span style="color: red;">{{$errors->first('price')}}</span>
                                            <input type="number" class="form-control" name="stock" value="{{old('stock')}}" id="stock" placeholder="Stock" required>
                                        </div>
                                        <button type="submit" class="btn btn-success">Ajouter</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="span6">
                    <div class="widget-box">
                        <div class="widget-title"> <span class="icon"><i class="icon-time"></i></span>
                            <h5>Liste Produits Attributs</h5>
                        </div>
                        <div class="widget-content nopadding">
                            <form action="{{route('product_attr.update',$product->id)}}" method="post" role="form">
                                {{method_field("PUT")}}
                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                                <table class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>Couleur</th>
                                    <th>Taille</th>
                                    <th>Prix</th>
                                    <th>Stock</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($attributes as $attribute)
                                    <input type="hidden" name="id[]" value="{{$attribute->id}}">
                                <tr>
                                    <td class="taskDesc">
                                        <input type="text" name="produit[]" id="sku" class="form-control" value="{{$attribute->sku}}" required="required" style="width: 75px;">
                                    </td>
                                    <td class="taskStatus">
                                        <input type="text" name="taille[]" id="size" class="form-control" value="{{$attribute->size}}" required="required" style="width: 75px;">
                                    </td>
                                    <td class="taskOptions">
                                        <input type="text" name="prix[]" id="price" class="form-control" value="{{$attribute->price}}" required="required" style="width: 75px;">
                                    </td>
                                    <td class="taskOptions">
                                        <input type="text" name="stock[]" id="stock" class="form-control" value="{{$attribute->stock}}" required="required" style="width: 75px;">
                                    </td>
                                    <td style="text-align: center; ">
                                        <button type="submit" class="btn btn-success btn-mini">Modifier</button>
                                        <a href="javascript:" rel="{{$attribute->id}}" rel1="delete-attribute" class="btn btn-danger btn-mini deleteRecord">Supprimer</a>
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
    </div>
@endsection
@section('jsblock')
    <script src="{{asset('js/jquery.min.js')}}"></script>
    <script src="{{asset('js/jquery.ui.custom.js')}}"></script>
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
    <script src="{{asset('js/bootstrap-colorpicker.js')}}"></script>
    <script src="{{asset('js/jquery.toggle.buttons.js')}}"></script>
    <script src="{{asset('js/masked.js')}}"></script>
    <script src="{{asset('js/jquery.uniform.js')}}"></script>
    <script src="{{asset('js/select2.min.js')}}"></script>
    <script src="{{asset('js/matrix.js')}}"></script>
    <script src="{{asset('js/matrix.form_common.js')}}"></script>
    <script src="{{asset('js/wysihtml5-0.3.0.js')}}"></script>
    <script src="{{asset('js/jquery.peity.min.js')}}"></script>
    <script src="{{asset('js/bootstrap-wysihtml5.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
    <script>
        $(".deleteRecord").click(function () {
            var id=$(this).attr('rel');
            var deleteFunction=$(this).attr('rel1');
            swal({
                title:'Etes-vous sure?',
                text:"Vous ne pourrez pas annuler cela!",
                type:'Attention',
                showCancelButton:true,
                confirmButtonColor:'#3085d6',
                cancelButtonColor:'#d33',
                confirmButtonText:'Yes, delete it!',
                cancelButtonText:'No, cancel!',
                confirmButtonClass:'btn btn-success',
                cancelButtonClass:'btn btn-danger',
                buttonsStyling:false,
                reverseButtons:true
            },function () {
                window.location.href="/admin/"+deleteFunction+"/"+id;
            });
        });
    </script>
@endsection
