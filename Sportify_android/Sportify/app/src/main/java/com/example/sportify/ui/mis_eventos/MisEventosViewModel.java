package com.example.sportify.ui.mis_eventos;

import androidx.lifecycle.LiveData;
import androidx.lifecycle.MutableLiveData;
import androidx.lifecycle.ViewModel;

public class MisEventosViewModel extends ViewModel {

    private MutableLiveData<String> mText;

    public MisEventosViewModel() {
        mText = new MutableLiveData<>();
        mText.setValue("This is dashboard fragment");
    }

    public LiveData<String> getText() {
        return mText;
    }
}