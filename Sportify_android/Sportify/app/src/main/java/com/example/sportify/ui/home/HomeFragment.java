package com.example.sportify.ui.home;

import android.content.Intent;
import android.os.Bundle;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.Button;
import android.widget.ListView;
import android.widget.Toast;

import androidx.annotation.NonNull;
import androidx.fragment.app.Fragment;
import androidx.lifecycle.ViewModelProviders;

import com.basgeekball.awesomevalidation.AwesomeValidation;
import com.basgeekball.awesomevalidation.ValidationStyle;
import com.example.sportify.LoginActivity;
import com.example.sportify.R;
import com.example.sportify.TokenManager;
import com.example.sportify.Utils;
import com.example.sportify.entities.AccessToken;
import com.example.sportify.entities.ApiError;
import com.example.sportify.entities.eventos.Evento;
import com.example.sportify.entities.eventos.EventoAdapter;
import com.example.sportify.entities.eventos.ListaEventos;
import com.example.sportify.network.ApiService;
import com.example.sportify.network.RetrofitBuilder;
import com.example.sportify.ui.infoevento.InfoEventoActivity;

import java.util.List;

import butterknife.BindView;
import butterknife.ButterKnife;
import butterknife.Unbinder;
import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

import static android.content.Context.MODE_PRIVATE;

public class HomeFragment extends Fragment {

    private HomeViewModel homeViewModel;
    private static final String TAG = "HomeFragment";


    ApiService service;
    ApiService service_get_eventos;
    TokenManager tokenManager;
    AwesomeValidation validator;
    Call<AccessToken> call;
    Call<ListaEventos>call_eventos;
    private Unbinder unbinder;
    @BindView(R.id.logout)
    Button logout;

    ListView lista_todos_eventos;
    List<Evento> lista_eventos;

    public View onCreateView(@NonNull LayoutInflater inflater,
                             ViewGroup container, Bundle savedInstanceState) {

        homeViewModel =
                ViewModelProviders.of(this).get(HomeViewModel.class);
        View root = inflater.inflate(R.layout.fragment_home, container, false);

        unbinder = ButterKnife.bind(getActivity(),root);


        tokenManager = TokenManager.getInstance(this.getActivity().getSharedPreferences("prefs", MODE_PRIVATE));
        service = RetrofitBuilder.createServiceWithAuth(ApiService.class,tokenManager);
        service_get_eventos = RetrofitBuilder.createServiceWithAuth(ApiService.class,tokenManager);
        validator = new AwesomeValidation(ValidationStyle.TEXT_INPUT_LAYOUT);

        lista_todos_eventos = (ListView) root.findViewById(R.id.lista_todos_eventos);

        logout = root.findViewById(R.id.logout) ;
        logout.setOnClickListener(new View.OnClickListener() {

            public void onClick(View view) {
                logout();
            }
        });

        //Cargo todos los eventos
        cargar_todos_eventos();


        lista_todos_eventos.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> adapterView, View view, int position, long l) {
                ver_evento_concreto(adapterView,view,position,l);
            }
        });


        return root;
    }



    void logout() {


        call = service.logout();
        call.enqueue(new Callback<AccessToken>() {
            @Override
            public void onResponse(Call<AccessToken> call, Response<AccessToken> response) {



                if (response.isSuccessful()) {
                    tokenManager.deleteToken();
                    Toast.makeText(getActivity(), "Logout", Toast.LENGTH_LONG).show();
                    startActivity(new Intent(getActivity(), LoginActivity.class));
                    getActivity().finish();
                } else {
                    if (response.code() == 422) {
                        Toast.makeText(getActivity(), "ERROR 422", Toast.LENGTH_LONG).show();
                    }
                    if (response.code() == 401) {
                        ApiError apiError = Utils.converErrors(response.errorBody());
                        Log.w(TAG, "onResponse: " + response);
                        Toast.makeText(getActivity(), apiError.getMessage(), Toast.LENGTH_LONG).show();
                    }
                }

            }

            @Override
            public void onFailure(Call<AccessToken> call, Throwable t) {
                Log.w(TAG, "onFailure: " + t.getMessage());
            }
        });

    }

    void cargar_todos_eventos(){

        call_eventos = service_get_eventos.eventos();
        call_eventos.enqueue(new Callback<ListaEventos>() {
            @Override
            public void onResponse(Call<ListaEventos> call, Response<ListaEventos> response) {



                if (response.isSuccessful()) {

                    lista_eventos = response.body().getData();



                    EventoAdapter adapter = new EventoAdapter(getContext(),lista_eventos);
                    lista_todos_eventos.setAdapter(adapter);
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
            public void onFailure(Call<ListaEventos> call, Throwable t) {
                Log.w(TAG, "onFailure: " + t.getMessage());
            }
        });
    }

    //Click en evento de la lista
    public void ver_evento_concreto(AdapterView<?> adapterView, View view, int position, long l){
        Evento evento = lista_eventos.get(position);


        Intent intent = new Intent(getActivity(), InfoEventoActivity.class);
        intent.putExtra("evento", evento);
        startActivity(intent);

    }

    @Override public void onDestroyView() {
        super.onDestroyView();
        unbinder.unbind();
        if (call_eventos != null) {
            call_eventos.cancel();
            call_eventos = null;
        }
        if (call != null) {
            call.cancel();
            call = null;
        }
    }



    }
