package com.example.sportify.ui.chatconcreto;

import androidx.appcompat.app.AppCompatActivity;

import android.os.Bundle;
import android.util.Log;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.Toast;

import com.basgeekball.awesomevalidation.AwesomeValidation;
import com.basgeekball.awesomevalidation.ValidationStyle;
import com.example.sportify.R;
import com.example.sportify.TokenManager;
import com.example.sportify.Utils;
import com.example.sportify.entities.ApiError;
import com.example.sportify.entities.chats.Chat;
import com.example.sportify.entities.chats.ChatAdapter;
import com.example.sportify.entities.chats.ListaChat;
import com.example.sportify.entities.chats.ListaMensajesChat;
import com.example.sportify.entities.chats.MensajeAdapter;
import com.example.sportify.entities.chats.MensajeChat;
import com.example.sportify.entities.eventos.Evento;
import com.example.sportify.network.ApiService;
import com.example.sportify.network.RetrofitBuilder;
import com.google.android.material.textfield.TextInputLayout;

import java.util.List;

import butterknife.BindView;
import butterknife.ButterKnife;
import butterknife.OnClick;
import butterknife.Unbinder;
import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class ChatActivity extends AppCompatActivity {

    private static final String TAG = "ChatsFragment";

    private Unbinder unbinder;

    ApiService service_get_mensajes;
    ApiService service_enviar;
    TokenManager tokenManager;
    AwesomeValidation validator;
    Call<ListaMensajesChat> call_mensajes;
    Call<String> call_enviado;

    Chat chat;

    List<MensajeChat> lista_mensajes;
    ListView lista_todos_mensajes;
    @BindView(R.id.t_titulo_chat_concreto)
    TextView t_titulo_chat_concreto;
    @BindView(R.id.til_mensaje)
    TextInputLayout cuerpo_mensaje;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_chat);

        tokenManager = TokenManager.getInstance(ChatActivity.this.getSharedPreferences("prefs", MODE_PRIVATE));
        service_get_mensajes = RetrofitBuilder.createServiceWithAuth(ApiService.class,tokenManager);
        service_enviar = RetrofitBuilder.createServiceWithAuth(ApiService.class,tokenManager);
        validator = new AwesomeValidation(ValidationStyle.TEXT_INPUT_LAYOUT);
        unbinder = ButterKnife.bind(ChatActivity.this);

        chat = (Chat) getIntent().getSerializableExtra("chat");

        t_titulo_chat_concreto.setText(chat.getNombre_grupo());
        lista_todos_mensajes = (ListView) this.findViewById(R.id.lista_mensajes_view);
        cargar_mensajes();

    }

    public void cargar_mensajes(){
        call_mensajes = service_get_mensajes.chat_concreto(chat.getId_grupo_conv());
        call_mensajes.enqueue(new Callback<ListaMensajesChat>() {
            @Override
            public void onResponse(Call<ListaMensajesChat> call, Response<ListaMensajesChat> response) {


                if (response.isSuccessful()) {

                    lista_mensajes = response.body().getData();

                    MensajeAdapter adapter = new MensajeAdapter(ChatActivity.this,lista_mensajes);
                    lista_todos_mensajes.setAdapter(adapter);
                } else {
                    if (response.code() == 422) {
                        Toast.makeText(ChatActivity.this, "ERROR 422", Toast.LENGTH_LONG).show();
                    }
                    if (response.code() == 401) {
                        ApiError apiError = Utils.converErrors(response.errorBody());
                        Toast.makeText(ChatActivity.this, apiError.getMessage(), Toast.LENGTH_LONG).show();
                    }
                }
            }

            @Override
            public void onFailure(Call<ListaMensajesChat> call, Throwable t) {
                Log.w(TAG, "onFailure: " + t.getMessage());
            }
        });

    }

    @OnClick(R.id.btn_send)
    void publicar_mensaje(){
        validator.clear();

        if (validator.validate()) {
            if (! cuerpo_mensaje.getEditText().getText().toString().equals("")) {
                call_enviado = service_enviar.publicar_mensaje(chat.getId_grupo_conv(), cuerpo_mensaje.getEditText().getText().toString());

                call_enviado.enqueue(new Callback<String>() {
                    @Override
                    public void onResponse(Call<String> call, Response<String> response) {


                        if (response.isSuccessful()) {

                            String mensaje = response.body();

                            if (mensaje.equals("correcto")) {

                                cargar_mensajes();
                                cuerpo_mensaje.getEditText().setText("");
                            }
                        } else {
                            if (response.code() == 422) {
                                Toast.makeText(ChatActivity.this, "ERROR 422", Toast.LENGTH_LONG).show();
                            }
                            if (response.code() == 401) {
                                ApiError apiError = Utils.converErrors(response.errorBody());
                                Toast.makeText(ChatActivity.this, apiError.getMessage(), Toast.LENGTH_LONG).show();
                            }
                        }

                    }

                    @Override
                    public void onFailure(Call<String> call, Throwable t) {
                        Log.w(TAG, "onFailure: " + t.getMessage());
                    }
                });
            }
        }
    }

    @Override
    public void onDestroy() {
        super.onDestroy();
        unbinder.unbind();
        if (call_mensajes != null) {
            call_mensajes.cancel();
            call_mensajes = null;
        }
    }
}