package com.example.nurmu.stpkd.view.activity;

import android.app.Activity;
import android.content.Intent;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

import com.example.nurmu.stpkd.R;
import com.example.nurmu.stpkd.model.Surveyor;
import com.example.nurmu.stpkd.utility.Config;
import com.onurciner.webserviceconnect.MethodType;
import com.onurciner.webserviceconnect.WebServiceSendData;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.IOException;

/**
 * Created by nurmu on 05/26/2017.
 */

public class LoginActivity extends AppCompatActivity implements View.OnClickListener{

    private Button btnLogin;
    private EditText txtUsername;
    private EditText txtPassword;
    private String url = Config.baseURL;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_login);

        txtUsername = (EditText) findViewById(R.id.txtUsername);
        txtPassword = (EditText) findViewById(R.id.txtPassword);

        btnLogin = (Button) findViewById(R.id.btnLogin);
        btnLogin.setOnClickListener(this);
    }

    @Override
    public void onClick(View v) {
        if(v == btnLogin){
            String username = "username=" + txtUsername.getText().toString();
            String password = "password=" + txtPassword.getText().toString();

            try {
                String result = (String) new WebServiceSendData()
                        .setUrl(Config.baseURL + "/user/login")
                        .setData(username + "&" + password)
                        .setRequestMethod(MethodType.POST)
                        .connect();
                Log.d("data sercive", result);
                try {

                    JSONObject dataAsliService = new JSONObject(result);
                    if (dataAsliService != null) {
                        JSONArray data = dataAsliService.getJSONArray("data");
                        int status = dataAsliService.getInt("status");

                        if (status == 1) {
                            JSONObject user = data.getJSONObject(0);

                            String surveyor_id = user.getString("surveyor_id");
                            String surveyor_pilkada_tps_id = user.getString("surveyor_pilkada_tps_id");
                            String surveyor_nip = user.getString("surveyor_nip");
                            String surveyor_username = user.getString("surveyor_username");
                            String surveyor_password = user.getString("surveyor_password");
                            String surveyor_address = user.getString("surveyor_address");
                            String surveyor_photo = user.getString("surveyor_photo");
                            String surveyor_phone = user.getString("surveyor_phone");
                            String surveyor_email = user.getString("surveyor_email");
                            String surveyor_create_by = user.getString("surveyor_create_by");
                            String surveyor_create_date = user.getString("surveyor_create_date");
                            String surveyor_status = user.getString("surveyor_status");
                            String surveyor_log_code = user.getString("surveyor_log_code");
                            String surveyor_fullname = user.getString("surveyor_fullname");

                            Surveyor surveyorObj = new Surveyor(surveyor_id, surveyor_pilkada_tps_id, surveyor_nip, surveyor_fullname, surveyor_username, surveyor_password, surveyor_address, surveyor_photo, surveyor_phone, surveyor_email, surveyor_create_by, surveyor_create_date, surveyor_status, surveyor_log_code);
                            Config.surveyor = surveyorObj;

                            changeActivity(this, MainActivity.class, true);
                        } else {
                            Toast.makeText(getApplicationContext(), "Username atau password salah", Toast.LENGTH_SHORT).show();
                        }
                    }
                } catch (JSONException e) {
                    e.printStackTrace();
                }

            } catch (IOException e) {
                e.printStackTrace();
            }

        }
    }

    public void changeActivity(Activity source, Class<?> destination, Boolean shouldFinishContext) {
        if (shouldFinishContext){
            source.finish();
        }
        Intent intent = new Intent(source, destination);
        source.startActivity(intent);
    }
}