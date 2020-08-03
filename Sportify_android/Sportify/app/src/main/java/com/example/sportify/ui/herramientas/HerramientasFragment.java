package com.example.sportify.ui.herramientas;

import androidx.core.content.ContextCompat;
import androidx.core.view.ViewCompat;
import androidx.lifecycle.ViewModelProviders;

import android.media.MediaPlayer;
import android.os.Bundle;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.fragment.app.Fragment;

import android.os.Handler;
import android.os.SystemClock;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;

import com.example.sportify.R;
import com.example.sportify.ui.chats.ChatsViewModel;
import com.example.sportify.ui.infoequipo.InfoEquipoActivity;
import com.google.android.material.textfield.TextInputLayout;

import butterknife.BindView;
import butterknife.ButterKnife;
import butterknife.OnClick;
import butterknife.Unbinder;

public class HerramientasFragment extends Fragment {

    private HerramientasViewModel herramientasViewModel;
    private static final String TAG = "HerramietnasFragment";


    TextView timer ;
    Button start;
    Button pause;
    Button reset;
    EditText t_alarma;

    /////////////////////////////////////////////////


    TextView tx_marcador_1;
    TextView tx_marcador_2;

    Button btn_p1_mas;
    Button btn_p1_menos;
    Button btn_p2_mas;
    Button btn_p2_menos;
    Button btn_marcador_restart;


    long MillisecondTime, StartTime, TimeBuff, UpdateTime = 0L ;
    Handler handler;
    int Seconds, Minutes, MilliSeconds ;

    MediaPlayer sonido_alarma;

    private Unbinder unbinder;

    @Override
    public View onCreateView(@NonNull LayoutInflater inflater, @Nullable ViewGroup container,
                             @Nullable Bundle savedInstanceState) {
        herramientasViewModel =
                ViewModelProviders.of(this).get(HerramientasViewModel.class);
        View root = inflater.inflate(R.layout.herramientas_fragment, container, false);
        unbinder = ButterKnife.bind(getActivity(),root);

        sonido_alarma = MediaPlayer.create(getContext(),R.raw.alarma);

        t_alarma = (EditText) root.findViewById(R.id.tx_tiempo_alarma);
        timer = (TextView)root.findViewById(R.id.tx_reloj);
        start = (Button)root.findViewById(R.id.btn_start);
        pause = (Button)root.findViewById(R.id.btn_pause);
        reset = (Button)root.findViewById(R.id.btn_restart);

        handler = new Handler();
        //Si pulso START
        start.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                StartTime = SystemClock.uptimeMillis();
                handler.postDelayed(runnable, 100);

                reset.setEnabled(false);
                ViewCompat.setBackgroundTintList(reset, ContextCompat.getColorStateList(getContext(), R.color.boton_gris));

            }
        });

        //Si pulso PAUSE
        pause.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                TimeBuff += MillisecondTime;
                handler.removeCallbacks(runnable);
                reset.setEnabled(true);
                ViewCompat.setBackgroundTintList(reset, ContextCompat.getColorStateList(getContext(), R.color.colorPrimary));

            }
        });


        //Si pulso RESTART
        reset.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                MillisecondTime = 0L ;
                StartTime = 0L ;
                TimeBuff = 0L ;
                UpdateTime = 0L ;
                Seconds = 0 ;
                Minutes = 0 ;
                MilliSeconds = 0 ;

                timer.setText("00:00:00");
            }
        });


        tx_marcador_1 = (TextView)root.findViewById(R.id.tx_marcador_1);
        tx_marcador_2 = (TextView)root.findViewById(R.id.tx_marcador_2);
        btn_p1_mas = (Button)root.findViewById(R.id.btn_p1_mas);
        btn_p1_menos = (Button)root.findViewById(R.id.btn_p1_menos);
        btn_p2_mas = (Button)root.findViewById(R.id.btn_p2_mas);
        btn_p2_menos  = (Button)root.findViewById(R.id.btn_p2_menos);
        btn_marcador_restart  = (Button)root.findViewById(R.id.btn_marcador_restart);

        btn_p1_mas.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                incremetnar_marcador_1();
            }
        });

        btn_p1_menos.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                decrementar_marcador_1();
            }
        });

        btn_p2_mas.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                incremetnar_marcador_2();
            }
        });

        btn_p2_menos.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                decrementar_marcador_2();
            }
        });

        btn_marcador_restart.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                restart_marcador();
            }
        });

        return root;
    }


    public Runnable runnable = new Runnable() {

        public void run() {

            MillisecondTime = SystemClock.uptimeMillis() - StartTime;

            UpdateTime = TimeBuff + MillisecondTime;

            Seconds = (int) (UpdateTime / 1000);

            Minutes = Seconds / 60;

            Seconds = Seconds % 60;

            MilliSeconds = (int) (UpdateTime % 1000);

            timer.setText("" + String.format("%02d", Minutes) + ":"
                    + String.format("%02d", Seconds) + ":"
                    + String.format("%02d", MilliSeconds));

            if(!t_alarma.getText().toString().equals("")) {

                int alarma = Integer.valueOf(t_alarma.getText().toString()) * 60000;
                if (UpdateTime >= alarma) {
                    //Si ha pasado el tiempo lo paro y permito RESET

                    handler.removeCallbacks(runnable);
                    reset.setEnabled(true);
                    ViewCompat.setBackgroundTintList(reset, ContextCompat.getColorStateList(getContext(), R.color.colorPrimary));

                    //Hago sonar alarma
                    sonido_alarma.start();
                }
            }

            handler.postDelayed(this, 100);
        }

    };

    void incremetnar_marcador_1(){
        int anterior = Integer.valueOf(tx_marcador_1.getText().toString());
        anterior +=1;

        tx_marcador_1.setText(String.format("%02d", anterior));
    }

    void decrementar_marcador_1() {
        int anterior = Integer.valueOf(tx_marcador_1.getText().toString());
        if (anterior > 0) {
            anterior -= 1;

            tx_marcador_1.setText(String.format("%02d", anterior));
        }
    }

    public void incremetnar_marcador_2(){
        int anterior = Integer.valueOf(tx_marcador_2.getText().toString());
        anterior +=1;

        tx_marcador_2.setText(String.format("%02d", anterior));
    }

    public void decrementar_marcador_2() {
        int anterior = Integer.valueOf(tx_marcador_2.getText().toString());
        if (anterior > 0) {
            anterior -= 1;

            tx_marcador_2.setText(String.format("%02d", anterior));
        }
    }

    public void restart_marcador(){
        tx_marcador_1.setText(String.format("%02d", 0));
        tx_marcador_2.setText(String.format("%02d", 0));
    }

    @Override public void onDestroyView() {
        super.onDestroyView();
        unbinder.unbind();
        sonido_alarma.stop();
        sonido_alarma=null;
    }
}