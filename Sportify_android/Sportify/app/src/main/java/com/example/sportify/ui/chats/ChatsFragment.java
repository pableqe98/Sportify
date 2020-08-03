package com.example.sportify.ui.chats;

import androidx.lifecycle.ViewModelProviders;

import android.content.Intent;
import android.os.Bundle;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.fragment.app.Fragment;

import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.ListView;
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
import com.example.sportify.network.ApiService;
import com.example.sportify.network.RetrofitBuilder;
import com.example.sportify.ui.chatconcreto.ChatActivity;
import com.example.sportify.ui.infoevento.InfoEventoActivity;

import java.util.List;

import butterknife.ButterKnife;
import butterknife.Unbinder;
import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

import static android.content.Context.MODE_PRIVATE;

public class ChatsFragment extends Fragment {

    private ChatsViewModel chatsViewModel;
    private static final String TAG = "ChatsFragment";

    private Unbinder unbinder;

    ApiService service_get_chats;
    TokenManager tokenManager;
    AwesomeValidation validator;
    Call<ListaChat>call_chats;


    List<Chat> lista_chats;
    ListView lista_todos_chats;

    @Override
    public View onCreateView(@NonNull LayoutInflater inflater, @Nullable ViewGroup container,
                             @Nullable Bundle savedInstanceState) {
        chatsViewModel =
                ViewModelProviders.of(this).get(ChatsViewModel.class);
        View root = inflater.inflate(R.layout.chats_fragment, container, false);

        tokenManager = TokenManager.getInstance(this.getActivity().getSharedPreferences("prefs", MODE_PRIVATE));
        service_get_chats = RetrofitBuilder.createServiceWithAuth(ApiService.class,tokenManager);
        validator = new AwesomeValidation(ValidationStyle.TEXT_INPUT_LAYOUT);
        unbinder = ButterKnife.bind(getActivity(),root);

        lista_todos_chats = (ListView) root.findViewById(R.id.lista_chats_view);
        cargar_chats();

        lista_todos_chats.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> adapterView, View view, int i, long l) {
                ver_chat_concreto(adapterView,view,i,l);
            }
        });
        return root;
    }

    public void cargar_chats(){
        call_chats = service_get_chats.chats();
        call_chats.enqueue(new Callback<ListaChat>() {
            @Override
            public void onResponse(Call<ListaChat> call, Response<ListaChat> response) {


                if (response.isSuccessful()) {

                    lista_chats = response.body().getData();

                    ChatAdapter adapter = new ChatAdapter(getContext(),lista_chats);

                    lista_todos_chats.setAdapter(adapter);
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
            public void onFailure(Call<ListaChat> call, Throwable t) {
                Log.w(TAG, "onFailure: " + t.getMessage());
            }
        });
    }

    public void ver_chat_concreto(AdapterView<?> adapterView, View view, int position, long l){
        Chat chat = lista_chats.get(position);

        Intent intent = new Intent(getActivity(), ChatActivity.class);
        intent.putExtra("chat", chat);
        startActivity(intent);

    }

    @Override public void onDestroyView() {
        super.onDestroyView();
        unbinder.unbind();
        if (call_chats != null) {
            call_chats.cancel();
            call_chats = null;
        }
    }
}