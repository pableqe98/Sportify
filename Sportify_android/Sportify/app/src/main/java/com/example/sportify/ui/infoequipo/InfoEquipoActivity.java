package com.example.sportify.ui.infoequipo;

import androidx.appcompat.app.AppCompatActivity;
import androidx.core.content.ContextCompat;
import androidx.core.view.ViewCompat;

import android.os.Bundle;
import android.util.Log;
import android.widget.Button;
import android.widget.ImageView;
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
import com.example.sportify.entities.equipo.Equipo;
import com.example.sportify.entities.equipo.IntegranteEquipo;
import com.example.sportify.entities.equipo.ListaIntegranteEquipo;
import com.example.sportify.entities.eventos.ConsultaEvento;
import com.example.sportify.entities.eventos.Evento;
import com.example.sportify.entities.eventos.RespuestaEvento;
import com.example.sportify.network.ApiService;
import com.example.sportify.network.RetrofitBuilder;
import com.example.sportify.ui.infoevento.InfoEventoActivity;
import com.google.android.gms.maps.SupportMapFragment;
import com.squareup.picasso.Picasso;

import java.util.List;

import butterknife.BindView;
import butterknife.ButterKnife;
import butterknife.OnClick;
import butterknife.Unbinder;
import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class InfoEquipoActivity extends AppCompatActivity {

    private static final String TAG = "InfoEquipoActivity";

    private Unbinder unbinder;

    ApiService service_get_equipo;
    ApiService service_desapuntarse;

    TokenManager tokenManager;
    AwesomeValidation validator;
    Call<ListaIntegranteEquipo> call_equipo;
    Call<String> call_desapuntarse;
    Equipo equipo;


    @BindView(R.id.i_logo_equipo)
    ImageView imagen_equipo;

    @BindView(R.id.t_nombre_equipo)
    TextView nombre_equipo;

    @BindView(R.id.t_descripcion_equipo)
    TextView t_descripcion_equipo;

    @BindView(R.id.btn_salir_equipo)
    Button btn_salir_equipo;

    @BindView(R.id.tabla_integrantes_equipo)
    TableLayout tabla_integrantes_equipo;

    List<IntegranteEquipo> integrantes_equipo;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_info_equipo);

        unbinder = ButterKnife.bind(this);

        tokenManager = TokenManager.getInstance(InfoEquipoActivity.this.getSharedPreferences("prefs", MODE_PRIVATE));
        service_get_equipo = RetrofitBuilder.createServiceWithAuth(ApiService.class,tokenManager);
        service_desapuntarse = RetrofitBuilder.createServiceWithAuth(ApiService.class,tokenManager);
        validator = new AwesomeValidation(ValidationStyle.TEXT_INPUT_LAYOUT);


        equipo = (Equipo) getIntent().getSerializableExtra("equipo");

        Picasso.get().load("http://192.168.0.52/sportify/public/"+equipo.getLogo_equipo()).into(imagen_equipo);
        nombre_equipo.setText(equipo.getNombre_equipo());
        t_descripcion_equipo.setText(equipo.getDescripcion_equipo());

        cargar_integrantes();

    }


    public void cargar_integrantes(){
        call_equipo = service_get_equipo.equipo(equipo.getId_equipo());
        call_equipo.enqueue(new Callback<ListaIntegranteEquipo>() {
            @Override
            public void onResponse(Call<ListaIntegranteEquipo> call, Response<ListaIntegranteEquipo> response) {
                if (response.isSuccessful()) {
                    integrantes_equipo = response.body().getData();

                    hacer_tabla_integrantes();


                } else {
                    if (response.code() == 422) {
                        Toast.makeText(InfoEquipoActivity.this, "ERROR 422", Toast.LENGTH_LONG).show();
                    }
                    if (response.code() == 401) {
                        ApiError apiError = Utils.converErrors(response.errorBody());
                        Toast.makeText(InfoEquipoActivity.this, apiError.getMessage(), Toast.LENGTH_LONG).show();
                    }
                }
            }

            @Override
            public void onFailure(Call<ListaIntegranteEquipo> call, Throwable t) {
                Log.w(TAG, "onFailure: " + t.getMessage());
            }
        });
    }

    @OnClick(R.id.btn_salir_equipo)
    public void desapuntarse_equipo(){
        call_desapuntarse = service_desapuntarse.desapuntarse_equipo(equipo.getId_equipo());
        call_desapuntarse.enqueue(new Callback<String>() {
            @Override
            public void onResponse(Call<String> call, Response<String> response) {
                if (response.isSuccessful()) {

                    String mensaje = response.body();
                    if (mensaje.equals("correcto")){

                        btn_salir_equipo.setText("YA NO PERTENECES A ESTE EQUIPO");
                        btn_salir_equipo.setEnabled(false);
                        ViewCompat.setBackgroundTintList(btn_salir_equipo, ContextCompat.getColorStateList(InfoEquipoActivity.this, R.color.boton_gris));

                    }


                } else {
                    if (response.code() == 422) {
                        Toast.makeText(InfoEquipoActivity.this, "ERROR 422", Toast.LENGTH_LONG).show();
                    }
                    if (response.code() == 401) {
                        ApiError apiError = Utils.converErrors(response.errorBody());
                        Toast.makeText(InfoEquipoActivity.this, apiError.getMessage(), Toast.LENGTH_LONG).show();
                    }
                }
            }

            @Override
            public void onFailure(Call<String> call, Throwable t) {
                Log.w(TAG, "onFailure: " + t.getMessage());
            }
        });
    }

    public void hacer_tabla_integrantes(){
        TableRow cabecera_integrantes = (TableRow) getLayoutInflater().inflate(R.layout.cabecera_item,null);
        ((TextView) cabecera_integrantes.findViewById(R.id.p_celda_usuario)).setText("Usuario");
        ((TextView) cabecera_integrantes.findViewById(R.id.p_celda_puntuacion)).setText("Email");

        tabla_integrantes_equipo.addView(cabecera_integrantes);

        for (IntegranteEquipo integrante : integrantes_equipo){
            if (!integrante.getNombre_usuario().equals("")) {
                TableRow tr = (TableRow) getLayoutInflater().inflate(R.layout.fila_item, null);
                ((TextView) tr.findViewById(R.id.p_celda_usuario)).setText(integrante.getNombre_usuario());
                ((TextView) tr.findViewById(R.id.p_celda_puntuacion)).setText(integrante.getEmail());
                tabla_integrantes_equipo.addView(tr);
            }
        }

    }
    @Override
    protected void onDestroy() {
        super.onDestroy();
        unbinder.unbind();
    }
}