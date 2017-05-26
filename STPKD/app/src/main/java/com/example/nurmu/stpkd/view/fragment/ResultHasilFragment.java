package com.example.nurmu.stpkd.view.fragment;

import android.app.Fragment;
import android.os.Bundle;
import android.support.annotation.Nullable;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.TableLayout;
import android.widget.TableRow;
import android.widget.TextView;
import android.widget.Toast;

import com.example.nurmu.stpkd.R;
import com.example.nurmu.stpkd.model.Surveyor;
import com.example.nurmu.stpkd.utility.Config;
import com.master.glideimageview.GlideImageView;
import com.onurciner.webserviceconnect.MethodType;
import com.onurciner.webserviceconnect.WebServiceSendData;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.IOException;

/**
 * Created by nurmu on 05/26/2017.
 */

public class ResultHasilFragment extends Fragment {

    TextView txtNamaPilkada;
    TextView txtPutaran;
    TextView txtTPS;
    TextView txtUser;
    TextView txtTanggal;
    View view;
    GlideImageView glideImageView;

    @Nullable
    @Override
    public View onCreateView(LayoutInflater inflater, @Nullable ViewGroup container, Bundle savedInstanceState) {
        view = inflater.inflate(R.layout.fragment_result_hasil, container, false);

        txtNamaPilkada = (TextView) view.findViewById(R.id.txtNamaPilkada);
        txtPutaran = (TextView) view.findViewById(R.id.txtPutaran);
        txtTPS = (TextView) view.findViewById(R.id.txtTPS);
        txtUser = (TextView) view.findViewById(R.id.txtUser);
        txtTanggal = (TextView) view.findViewById(R.id.txtTanggal);
        glideImageView = (GlideImageView) view.findViewById(R.id.image);
        init();

        return view;
    }


    public void init() {
        try {
            String result = (String) new WebServiceSendData()
                    .setUrl(Config.baseURL + "/user/get_result")
                    .setData("id_user=" + Config.surveyor.getSurveyor_id())
                    .setRequestMethod(MethodType.POST)
                    .connect();

            Log.d("JSON GET", result);
            JSONObject dataAsliService = new JSONObject(result);
            if (dataAsliService != null) {
                JSONArray data = dataAsliService.getJSONArray("data");
                JSONObject user = data.getJSONObject(0);

                txtNamaPilkada.setText(user.getString("pilkada_name"));
                txtPutaran.setText(user.getString("pilkada_session_name"));
                txtTPS.setText(user.getString("pilkada_result_pilkada_tps_id"));
                txtUser.setText(Config.surveyor.getSurveyor_fullname());
                txtTanggal.setText(user.getString("pilkada_create_date"));
                glideImageView.loadImageUrl(Config.baseURL + "/" + user.getString("pilkada_result_imagepath"));


                StringBuilder nama = new StringBuilder();

                for (int i = 0; i < data.length(); i++) {
                    JSONObject user2 = data.getJSONObject(i);
                    nama.append(user2.getString("pilkada_candidate_name").concat(" ").concat(user2.getString("jumlah").concat("\n")));

                     /* Find Tablelayout defined in main.xml */
                    TableLayout tl = (TableLayout) view.findViewById(R.id.resultKandidat);
                    TableRow tr = new TableRow(view.getContext());
                    tr.setLayoutParams(new TableRow.LayoutParams(TableRow.LayoutParams.FILL_PARENT, TableRow.LayoutParams.WRAP_CONTENT));

                    TextView label = new TextView(view.getContext());
                    label.setText("Kandidat ");
                    label.setLayoutParams(new TableRow.LayoutParams(TableRow.LayoutParams.FILL_PARENT, TableRow.LayoutParams.WRAP_CONTENT));
                    tr.addView(label);

                    TextView value = new TextView(view.getContext());
                    value.setText(user2.getString("pilkada_candidate_name").concat(" (").concat(user2.getString("jumlah").concat(")")));
                    value.setLayoutParams(new TableRow.LayoutParams(TableRow.LayoutParams.FILL_PARENT, TableRow.LayoutParams.WRAP_CONTENT));
                    tr.addView(value);

                    tl.addView(tr, new TableLayout.LayoutParams(TableLayout.LayoutParams.FILL_PARENT, TableLayout.LayoutParams.WRAP_CONTENT));

                }

            }

        } catch (
                IOException e) {
            e.printStackTrace();
        } catch (
                JSONException e)

        {
            e.printStackTrace();
        }
    }
}
