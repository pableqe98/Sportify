package com.example.sportify.ui.equipos;

import android.content.Intent;
import android.os.Bundle;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.ListView;
import android.widget.Toast;

import androidx.annotation.NonNull;
import androidx.fragment.app.Fragment;
import androidx.lifecycle.ViewModelProviders;

import com.basgeekball.awesomevalidation.AwesomeValidation;
import com.basgeekball.awesomevalidation.ValidationStyle;
import com.example.sportify.R;
import com.example.sportify.TokenManager;
import com.example.sportify.Utils;
import com.example.sportify.entities.ApiError;
import com.example.sportify.entities.equipo.Equipo;
import com.example.sportify.entities.equipo.EquipoAdapter;
import com.example.sportify.entities.equipo.ListaEquipos;
import com.example.sportify.network.ApiService;
import com.example.sportify.network.RetrofitBuilder;
import com.example.sportify.ui.infoequipo.InfoEquipoActivity;

import java.util.List;

import butterknife.ButterKnife;
import butterknife.Unbinder;
import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

import static android.content.Context.MODE_PRIVATE;

public class EquiposFragment extends Fragment {

    private EquiposViewModel equiposViewModel;
    private static final String TAG = "HomeFragment";

    ApiService service_get_equipos;
    TokenManager tokenManager;
    AwesomeValidation validator;
    Call<ListaEquipos> call_equipos;
    private Unbinder unbinder;


    ListView lista_mis_equipos;
    List<Equipo> lista_equipos;

    public View onCreateView(@NonNull LayoutInflater inflater,
                             ViewGroup container, Bundle savedInstanceState) {
        equiposViewModel =
                ViewModelProviders.of(this).get(EquiposViewModel.class);
        View root = inflater.inflate(R.layout.fragment_equipos, container, false);

        unbinder = ButterKnife.bind(getActivity(),root);


        tokenManager = TokenManager.getInstance(this.getActivity().getSharedPreferences("prefs", MODE_PRIVATE));

        service_get_equipos = RetrofitBuilder.createServiceWithAuth(ApiService.class,tokenManager);
        validator = new AwesomeValidation(ValidationStyle.TEXT_INPUT_LAYOUT);

        lista_mis_equipos = (ListView) root.findViewById(R.id.lista_mis_equipos);

        //Cargo mis equipos
        cargar_mis_equipos();

        lista_mis_equipos.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> adapterView, View view, int position, long l) {
                ver_equipo_concreto(adapterView,view,position,l);
            }
        });

        return root;
    }

    public void cargar_mis_equipos(){

        call_equipos = service_get_equipos.mis_equipos();
        call_equipos.enqueue(new Callback<ListaEquipos>() {
            @Override
            public void onResponse(Call<ListaEquipos> call, Response<ListaEquipos> response) {



                if (response.isSuccessful()) {

                    lista_equipos = response.body().getData();


                    EquipoAdapter adapter = new EquipoAdapter(getContext(),lista_equipos);
                    lista_mis_equipos.setAdapter(adapter);
                } else {
                    if (response.code() == 422) {
                        Toast.makeText(getActivity(), "ERROR 422", Toast.LENGTH_LONG).show();
                    }
                    if (response.code() == 401) {
                        ApiError apiError = Utils.converErrors(response.errorBody());
                        Toast.makeText(getActivity(), apiError.getMessage(), Toast.LENGTH_LONG).show();
                    }
                }

            }

            @Override
            public void onFailure(Call<ListaEquipos> call, Throwable t) {
                Log.w(TAG, "onFailure: " + t.getMessage());
            }
        });
    }

    //Click en equipo de la lista
    public void ver_equipo_concreto(AdapterView<?> adapterView, View view, int position, long l){
        Equipo equipo = lista_equipos.get(position);


        Intent intent = new Intent(getActivity(), InfoEquipoActivity.class);
        intent.putExtra("equipo", equipo);
        startActivity(intent);

    }

    @Override public void onDestroyView() {
        super.onDestroyView();
        unbinder.unbind();
    }
}