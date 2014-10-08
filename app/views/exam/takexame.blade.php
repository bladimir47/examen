@extends('layouts.master')
@section('content')

<div class="row">
    <div class="col-md-12 col-lg-12">
        <h3>Listado De Preguntas</h3>
        <h2>{{$exampreguntas->titulo}}</h2>
        <div class="well">
            @if($varexamen->count())
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>ID-Examen</th>
                        <th>TipoRespuesta</th>
                        <th>Posibles respuestas</th>
                        <th>Respuesta Correcta</th>
                        <th>Pregunta</th>
                        <th>Punteo</th>

                    </tr>
                </thead>

                <tbody>
                    @foreach ($varexamen as $pregunta)
                    <tr>
                        <td>{{ $pregunta->id }}</td>
                        <td>{{ $exampreguntas->first()->curso()->first()->nombre }}</td>
                        <td>{{ $pregunta->tipo_respuesta }}</td>                       
                        <td> 
                            <?php
                            $apreguntas = $pregunta->respuestas;
                            if ($apreguntas == null) {
                                $apreguntas = array();
                            }
                            ?>
                            @foreach($apreguntas as $pres)
                            {{$pres->respuesta}}
                            @endforeach
                        </td>
                        <td>{{ $pregunta->respuesta_correcta }}</td>
                        <td>{{ $pregunta->pregunta}}</td>
                        <td>{{ $pregunta->punteo}}</td>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            No existen preguntas para mostrar
            @endif

        </div>
        <div class="col-md-12 col-lg-12">   
            <center><h1>*****{{$exampreguntas->titulo}}*****</h1></center>
            <div class="well" align='center'>

                {{ Form::open(array('id' => 'session_form','url' => 'exam/takexam/almacena-res/'.$exampreguntas->id, 'method'=>'post')) }}
                @foreach ($varexamen as $pregunta)
                @if ($pregunta->tipo_respuesta=="sel_mul")
                <div class="form-group">
                    <b><h3>{{$pregunta->pregunta}}</h3></b>
                    <?php $respuestas = Respuesta::where('pregunta', '=', $pregunta->id)->get() ?>

                <select name ="{{$pregunta->id}}">
                    @foreach ($respuestas as $respuesta)
                        <option value="{{$respuesta->respuesta}}">{{$respuesta->respuesta}}</option>
                    @endforeach
                </select>
                    
                </div>           
                @elseif ($pregunta->tipo_respuesta=="fv")
                <div class="form-group">
                    <b><h3>{{$pregunta->pregunta}}</h3></b>
                    {{ Form::select($pregunta->id, array(
                            'F' => 'F',
                            'V' => 'V',
                            ),null , array('class' => 'form-control')); }}

                </div>
                @else
                <td>no compara</td>
                @endif                        
                @endforeach
                {{ Form::submit('Enviar a Calificar', array('class' => 'btn btn-primary')) }}

                {{ Form::close() }}
            </div>

        </div>



    </div>
</div>
@stop
