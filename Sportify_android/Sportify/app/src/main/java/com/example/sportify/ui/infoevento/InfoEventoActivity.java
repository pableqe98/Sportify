package com.example.sportify.ui.infoevento;

import androidx.core.content.ContextCompat;
import androidx.core.view.ViewCompat;
import androidx.fragment.app.FragmentActivity;

import android.app.AlertDialog;
import android.content.DialogInterface;
import android.graphics.Color;
import android.os.Bundle;
import android.util.Log;
import android.view.MotionEvent;
import android.view.View;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.ListAdapter;
import android.widget.ScrollView;
import android.widget.TableLayout;
import android.widget.TableRow;
import android.widget.TextView;
import android.widget.Toast;

import com.basgeekball.awesomevalidation.AwesomeValidation;
import com.basgeekball.awesomevalidation.ValidationStyle;
import com.example.sportify.R;
import com.example.sportify.TokenManager;
import com.example.sportify.Utils;
import com.example.sportify.entities.ApiError;
import com.example.sportify.entities.enfrentamiento.Enfrentamiento;
import com.example.sportify.entities.equipo.Equipo;
import com.example.sportify.entities.eventos.ConsultaEvento;
import com.example.sportify.entities.eventos.Evento;
import com.example.sportify.entities.eventos.RespuestaEvento;
import com.example.sportify.entities.participante.Participante;
import com.example.sportify.network.ApiService;
import com.example.sportify.network.RetrofitBuilder;
import com.google.android.gms.maps.CameraUpdateFactory;
import com.google.android.gms.maps.GoogleMap;
import com.google.android.gms.maps.OnMapReadyCallback;
import com.google.android.gms.maps.SupportMapFragment;
import com.google.android.gms.maps.model.LatLng;
import com.google.android.gms.maps.model.MarkerOptions;
import com.google.android.material.tabs.TabLayout;
import com.squareup.picasso.Picasso;

import java.util.ArrayList;
import java.util.List;

import butterknife.BindView;
import butterknife.ButterKnife;
import butterknife.OnClick;
import butterknife.Unbinder;
import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class InfoEventoActivity extends FragmentActivity implements OnMapReadyCallback {
    private static final String TAG = "InfoEventoActivity";

    private Unbinder unbinder;

    ApiService service_get_evento;
    ApiService service_desapuntarse;
    ApiService service_apuntarse;
    TokenManager tokenManager;
    AwesomeValidation validator;
    Call<RespuestaEvento> call_evento;
    Call<String> call_desapuntarse;
    Call<String> call_apuntarse;
    Evento evento;

    @BindView(R.id.transparente)
    ImageView transparente;

    @BindView(R.id.id_scroll)
    ScrollView id_scroll;

    @BindView(R.id.imagen_evento)
    ImageView imagen_evento;

    @BindView(R.id.t_titulo_evento)
    TextView titulo_evento;

    @BindView(R.id.t_fecha)
    TextView t_fecha;

    @BindView(R.id.t_descripcion)
    TextView t_descripcion;

    @BindView(R.id.t_tematica)
    TextView t_tematica;

    @BindView(R.id.t_n_participantes)
    TextView t_n_participantes;

    @BindView(R.id.t_min_participantes)
    TextView t_min_participantes;

    @BindView(R.id.t_max_participantes)
    TextView t_max_participantes;

    @BindView(R.id.btn_apuntarse)
    Button btn_apuntarse;

    @BindView(R.id.tabla_puntuaciones)
    TableLayout tabla_puntuaciones;

    @BindView(R.id.tabla_integrantes)
    TableLayout tabla_integrantes;

    @BindView(R.id.tabla_enfrentamientos)
    TableLayout tabla_enfrentamientos;

    List<Enfrentamiento> enfrentamientos;
    String empezado="";
    String acabado="";
    String apuntado="";
    List<Equipo> equipos;
    List<Participante> participantes;
    String tipo_participante="";

    GoogleMap mapa_evento;
    SupportMapFragment mapFragment;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_info_evento);

        unbinder = ButterKnife.bind(this);

        tokenManager = TokenManager.getInstance(InfoEventoActivity.this.getSharedPreferences("prefs", MODE_PRIVATE));
        service_get_evento = RetrofitBuilder.createServiceWithAuth(ApiService.class,tokenManager);
        service_desapuntarse = RetrofitBuilder.createServiceWithAuth(ApiService.class,tokenManager);
        service_apuntarse = RetrofitBuilder.createServiceWithAuth(ApiService.class,tokenManager);
        validator = new AwesomeValidation(ValidationStyle.TEXT_INPUT_LAYOUT);


        evento = (Evento) getIntent().getSerializableExtra("evento");

        Picasso.get().load("http://192.168.0.52/sportify/public/"+evento.getFoto()).into(imagen_evento);
        titulo_evento.setText(evento.getTitulo_e());

        cargar_info_evento();

        //Configuro para mover el mapa dentro del ScrollView
        transparente.setOnTouchListener(new View.OnTouchListener() {
            @Override
            public boolean onTouch(View view, MotionEvent motionEvent) {

                int action = motionEvent.getAction();
                switch (action) {
                    case MotionEvent.ACTION_DOWN:
                        // Disallow ScrollView to intercept touch events.
                        id_scroll.requestDisallowInterceptTouchEvent(true);
                        // Disable touch on transparent view
                        return false;

                    case MotionEvent.ACTION_UP:
                        // Allow ScrollView to intercept touch events.
                        id_scroll.requestDisallowInterceptTouchEvent(false);
                        return true;

                    case MotionEvent.ACTION_MOVE:
                        id_scroll.requestDisallowInterceptTouchEvent(true);
                        return false;

                    default:
                        return true;
                }
            }
        });

    }

    public void cargar_info_evento(){

        call_evento = service_get_evento.evento(evento.getId_evento());
        call_evento.enqueue(new Callback<RespuestaEvento>() {
            @Override
            public void onResponse(Call<RespuestaEvento> call, Response<RespuestaEvento> response) {



                if (response.isSuccessful()) {

                    ConsultaEvento ej = response.body().getData();

                    //Obtengo los daots del evento y los muestro
                    String fecha = "Fecha inicio: "+evento.getFecha_ini()+" - Fecha fin: "+evento.getFecha_fin();
                    String descripcion = "Descripcion:\n"+evento.getDescripcion_e();
                    String tematica = "Tematica: "+evento.getTematica();
                    String n_participantes = "Numero participantes: "+evento.getN_participantes();
                    String min_participantes = "Minimo participantes: "+evento.getMin_participantes();
                    String max_participantes = "Maximo participantes: "+evento.getMax_participantes();

                    t_fecha.setText(fecha);
                    t_descripcion.setText(descripcion);
                    t_tematica.setText(tematica);
                    t_n_participantes.setText(n_participantes);
                    t_min_participantes.setText(min_participantes);
                    t_max_participantes.setText(max_participantes);


                    empezado=ej.getEmpezado();
                    acabado=ej.getAcabado();
                    apuntado=ej.getApuntado();
                    tipo_participante=ej.getTipo_participante();

                    configurar_boton();


                    enfrentamientos = ej.getEnfrentamientos();
                    equipos = ej.getEquipos();
                    participantes = ej.getParticipantes();


                    //Preparo las tablas
                    hacer_tablas_integrantes_puntuacion();
                    hacer_tabla_enfrentamientos();

                    //Configuro el mapa
                    mapFragment = (SupportMapFragment) getSupportFragmentManager().findFragmentById(R.id.evento_map);
                    mapFragment.getMapAsync(InfoEventoActivity.this);


                } else {
                    if (response.code() == 422) {
                        Toast.makeText(InfoEventoActivity.this, "ERROR 422", Toast.LENGTH_LONG).show();
                    }
                    if (response.code() == 401) {
                        ApiError apiError = Utils.converErrors(response.errorBody());
                        Toast.makeText(InfoEventoActivity.this, apiError.getMessage(), Toast.LENGTH_LONG).show();
                    }
                }

            }

            @Override
            public void onFailure(Call<RespuestaEvento> call, Throwable t) {
                Log.w(TAG, "onFailure: " + t.getMessage());
            }
        });
    }
    @Override
    protected void onDestroy() {
        super.onDestroy();
        unbinder.unbind();
    }

    @OnClick(R.id.btn_apuntarse)
    void apuntarse(){

        if(apuntado.equals("si")){

            call_desapuntarse = service_desapuntarse.desapuntarse(evento.getId_evento(),evento.getTipo());
            call_desapuntarse.enqueue(new Callback<String>() {
                @Override
                public void onResponse(Call<String> call, Response<String> response) {
                    if (response.isSuccessful()) {

                        String mensaje = response.body();
                        if (mensaje.equals("correcto")){
                            apuntado ="no";
                            configurar_boton();
                        }


                    } else {
                        if (response.code() == 422) {
                            Toast.makeText(InfoEventoActivity.this, "ERROR 422", Toast.LENGTH_LONG).show();
                        }
                        if (response.code() == 401) {
                            ApiError apiError = Utils.converErrors(response.errorBody());
                            Toast.makeText(InfoEventoActivity.this, apiError.getMessage(), Toast.LENGTH_LONG).show();
                        }
                    }
                }

                @Override
                public void onFailure(Call<String> call, Throwable t) {
                    Log.w(TAG, "onFailure: " + t.getMessage());
                }
            });

        }
        else if (apuntado.equals("no") && empezado.equals("no")){

            if (tipo_participante.equals("INDIVIDUAL")){
                call_apuntarse = service_apuntarse.apuntarse(evento.getId_evento(),tipo_participante,-1);
                call_apuntarse.enqueue(new Callback<String>() {
                    @Override
                    public void onResponse(Call<String> call, Response<String> response) {
                        if (response.isSuccessful()) {

                            String mensaje = response.body();
                            if (mensaje.equals("correcto")){
                                apuntado ="si";
                                configurar_boton();

                            }

                        } else {
                            if (response.code() == 422) {
                                Toast.makeText(InfoEventoActivity.this, "ERROR 422", Toast.LENGTH_LONG).show();
                            }
                            if (response.code() == 401) {
                                ApiError apiError = Utils.converErrors(response.errorBody());
                                Toast.makeText(InfoEventoActivity.this, apiError.getMessage(), Toast.LENGTH_LONG).show();
                            }
                        }
                    }

                    @Override
                    public void onFailure(Call<String> call, Throwable t) {
                        Log.w(TAG, "onFailure: " + t.getMessage());
                    }
                });
            }
            else{
                //Si me quiero apuntar como equipo
                //Abro un dialogo para elegir el equipo
                AlertDialog dialogo_equipo = createRadioListDialog();
                dialogo_equipo.show();
            }
        }
    }

    public AlertDialog createRadioListDialog() {
        AlertDialog.Builder builder = new AlertDialog.Builder(InfoEventoActivity.this);

        List<String> ids_equipos = new ArrayList<String>();

        for (Equipo equipo : equipos){
            ids_equipos.add(equipo.getNombre_equipo());
        }


        builder.setTitle("Elegir Equipo")
                .setSingleChoiceItems(ids_equipos.toArray(new String[ids_equipos.size()]), 0, new DialogInterface.OnClickListener() {
                    @Override
                    public void onClick(DialogInterface dialog, int which) {
                        int id_equipo = equipos.get(which).getId_equipo();

                        call_apuntarse = service_apuntarse.apuntarse(evento.getId_evento(),tipo_participante,id_equipo);
                        call_apuntarse.enqueue(new Callback<String>() {
                            @Override
                            public void onResponse(Call<String> call, Response<String> response) {
                                if (response.isSuccessful()) {

                                    String mensaje = response.body();
                                    if (mensaje.equals("correcto")){
                                        Log.w(TAG, "ID EQUIPO " +id_equipo+" "+mensaje);
                                        dialog.dismiss();
                                        apuntado ="si";
                                        configurar_boton();

                                    }

                                } else {
                                    if (response.code() == 422) {
                                        //handleErrors(response.errorBody());
                                        Toast.makeText(InfoEventoActivity.this, "ERROR 422", Toast.LENGTH_LONG).show();
                                    }
                                    if (response.code() == 401) {
                                        ApiError apiError = Utils.converErrors(response.errorBody());
                                        Toast.makeText(InfoEventoActivity.this, apiError.getMessage(), Toast.LENGTH_LONG).show();
                                    }
                                }
                            }

                            @Override
                            public void onFailure(Call<String> call, Throwable t) {
                                Log.w(TAG, "onFailure: " + t.getMessage());
                            }
                        });
                    }
                });

        return builder.create();
    }

    public void configurar_boton(){
        if (acabado.equals("si")){
            btn_apuntarse.setText("ACABADO");
            btn_apuntarse.setEnabled(false);
            ViewCompat.setBackgroundTintList(btn_apuntarse, ContextCompat.getColorStateList(InfoEventoActivity.this, R.color.boton_gris));
        }
        else if(apuntado.equals("si")){
            btn_apuntarse.setText("DESAPUNTARME");
            btn_apuntarse.setEnabled(true);
            ViewCompat.setBackgroundTintList(btn_apuntarse, ContextCompat.getColorStateList(InfoEventoActivity.this, R.color.boton_rojo));

        }
        else if(empezado.equals("si")){
            btn_apuntarse.setText("YA NO PUEDES APUNTARTE");
            btn_apuntarse.setEnabled(false);
            ViewCompat.setBackgroundTintList(btn_apuntarse, ContextCompat.getColorStateList(InfoEventoActivity.this, R.color.boton_gris));
        }
        else if (apuntado.equals("lleno")){
            btn_apuntarse.setText("LLENO");
            btn_apuntarse.setEnabled(false);
            ViewCompat.setBackgroundTintList(btn_apuntarse, ContextCompat.getColorStateList(InfoEventoActivity.this, R.color.boton_gris));
        }
        else if (apuntado.equals("no") && empezado.equals("no")){
            btn_apuntarse.setText("APUNTATE");
            btn_apuntarse.setEnabled(true);
            ViewCompat.setBackgroundTintList(btn_apuntarse, ContextCompat.getColorStateList(InfoEventoActivity.this, R.color.colorPrimary));
        }
    }

    public void hacer_tabla_enfrentamientos(){
        TableRow cabecera_enfrentamientos = (TableRow) getLayoutInflater().inflate(R.layout.cabecera_enfrentamientos_item, null);
        ((TextView) cabecera_enfrentamientos.findViewById(R.id.p_celda_usuario1)).setText("Participante 1");
        ((TextView) cabecera_enfrentamientos.findViewById(R.id.p_celda_puntuacion1)).setText("Puntuacion 1");
        ((TextView) cabecera_enfrentamientos.findViewById(R.id.p_celda_usuario2)).setText("Participante 2");
        ((TextView) cabecera_enfrentamientos.findViewById(R.id.p_celda_puntuacion2)).setText("Puntuacion 2");

        tabla_enfrentamientos.addView(cabecera_enfrentamientos);
        for (Enfrentamiento enfrentamiento : enfrentamientos){
            if (enfrentamiento.getPuntos_1() != -1) {
                TableRow tr = (TableRow) getLayoutInflater().inflate(R.layout.fila_enfrentamientos_item, null);
                ((TextView) tr.findViewById(R.id.p_celda_usuario1)).setText(enfrentamiento.getNombre1());
                ((TextView) tr.findViewById(R.id.p_celda_puntuacion1)).setText(Integer.toString(enfrentamiento.getPuntos_1()));
                ((TextView) tr.findViewById(R.id.p_celda_usuario2)).setText(enfrentamiento.getNombre2());
                ((TextView) tr.findViewById(R.id.p_celda_puntuacion2)).setText(Integer.toString(enfrentamiento.getPuntos_2()));

                tabla_enfrentamientos.addView(tr);
            }
        }
    }

    public void hacer_tablas_integrantes_puntuacion(){
        //Preparo las tablas de puntuaciones e integrantes con su cabecera
        TableRow cabecera_puntuaciones = (TableRow) getLayoutInflater().inflate(R.layout.cabecera_item, null);
        ((TextView) cabecera_puntuaciones.findViewById(R.id.p_celda_usuario)).setText("Usuario");
        if (evento.getTipo().equals("LIGA")) {
            ((TextView) cabecera_puntuaciones.findViewById(R.id.p_celda_puntuacion)).setText("Puntos");
        } else if (evento.getTipo().equals("TORNEO")) {
            ((TextView) cabecera_puntuaciones.findViewById(R.id.p_celda_puntuacion)).setText("Posicion");
        } else {
            ((TextView) cabecera_puntuaciones.findViewById(R.id.p_celda_puntuacion)).setText("Anotados");
        }
        tabla_puntuaciones.addView(cabecera_puntuaciones);

        TableRow cabecera_integrantes = (TableRow) getLayoutInflater().inflate(R.layout.cabecera_item, null);
        ((TextView) cabecera_integrantes.findViewById(R.id.p_celda_usuario)).setText("Usuario");
        if (evento.getTipo_participantes().equals("INDIVIDUAL")){
            ((TextView) cabecera_integrantes.findViewById(R.id.p_celda_puntuacion)).setText("Valoracion");
        }
        else{
            ((TextView) cabecera_integrantes.findViewById(R.id.p_celda_puntuacion)).setText("N.Participantes");
        }
        tabla_integrantes.addView(cabecera_integrantes);

        for (Participante participante : participantes){
            TableRow tr = (TableRow) getLayoutInflater().inflate(R.layout.fila_item, null);
            ((TextView) tr.findViewById(R.id.p_celda_puntuacion)).setText(participante.getNombre());
            if (participante.getAnotados() != -1) {
                tr = (TableRow) getLayoutInflater().inflate(R.layout.fila_item, null);
                ((TextView) tr.findViewById(R.id.p_celda_usuario)).setText(participante.getNombre());
                String tipo_evento = evento.getTipo();

                if (tipo_evento.equals("LIGA")) {
                    ((TextView) tr.findViewById(R.id.p_celda_puntuacion)).setText(Integer.toString(participante.getPuntos()));
                } else if (tipo_evento.equals("TORNEO")) {
                    ((TextView) tr.findViewById(R.id.p_celda_puntuacion)).setText(participante.getPosicion());
                } else {
                    ((TextView) tr.findViewById(R.id.p_celda_puntuacion)).setText(Integer.toString(participante.getAnotados()));
                }

                tabla_puntuaciones.addView(tr);

                TableRow fila_integrante = (TableRow) getLayoutInflater().inflate(R.layout.fila_item, null);
                ((TextView) fila_integrante.findViewById(R.id.p_celda_usuario)).setText(participante.getNombre());
                ((TextView) fila_integrante.findViewById(R.id.p_celda_puntuacion)).setText(Integer.toString(participante.getExtra()));
                tabla_integrantes.addView(fila_integrante);
            }


        }

    }



    @Override
    public void onMapReady(GoogleMap googleMap) {
        mapa_evento=googleMap;

        LatLng latlng = new LatLng(evento.getLatitud(), evento.getLongitud());
        mapa_evento.addMarker(new MarkerOptions()
                .position(latlng)
                .title(evento.getTitulo_e()));

        mapa_evento.moveCamera(CameraUpdateFactory.newLatLngZoom(latlng,15));
    }
}