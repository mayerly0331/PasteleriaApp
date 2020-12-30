@extends('auth.contenido')

@section('login')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card-group mb-0">
            <div class="card p-4">
                <form class="form-horizontal was-validated" method="POST" action="{{ route('login') }}">
                    {{ csrf_field() }}
                    <div class="card-body text-center">
                        <h3>Iniciar sesión</h3>
                        <p class="text-muted"></p>
                        <div class="form-group mb-3{$errors->has('usuario' ? 'is-invalid' : '')}}">
                            <span class="input-group-addon"><i class="icon-user"></i></span>
                            <input type="text" value="{{ old('usuario') }}" name="usuario" id="usuario"
                                class="form-control" placeholder="Usuario">
                            {!!$errors->first('usuario','<span class="invalid-feedback">:message</span>')!!}
                        </div>
                        <div class="form-group mb-4{{$errors->has('password' ? 'is-invalid' : '')}}">
                            <span class="input-group-addon"><i class="icon-lock"></i></span>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                            {!!$errors->first('password','<span class="invalid-feedback">:message</span>')!!}
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-dark text-white"><i class="fa fa-sign-in"></i> Ingresar</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
			<div class="card text-dark bg-info">
				<div class="card-body text-center">
					<img src="img/Hela.png" class="card-img-top" >
					<h1>Pasteleria</h1> 
                <p class="card-subtitle mb-2 text-muted">Desarrollado por Maye M.</p> 
				</div>
			</div>
        </div>
	</div>
</div>


@endsection
