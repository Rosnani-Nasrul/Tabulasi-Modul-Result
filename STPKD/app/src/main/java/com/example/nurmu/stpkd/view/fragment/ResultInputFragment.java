package com.example.nurmu.stpkd.view.fragment;

import android.app.Fragment;
import android.os.Bundle;
import android.support.annotation.Nullable;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Spinner;
import android.widget.TableLayout;
import android.widget.TableRow;
import android.widget.TextView;

import com.example.nurmu.stpkd.R;
import com.example.nurmu.stpkd.utility.Config;
import com.onurciner.webserviceconnect.MethodType;
import com.onurciner.webserviceconnect.RequestPropertyType;
import com.onurciner.webserviceconnect.WebServiceSendData;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.IOException;
import java.util.HashMap;
import java.util.Iterator;
import java.util.Map;

/**
 * Created by nurmu on 05/26/2017.
 */

public class ResultInputFragment extends Fragment {

    View view;
    String[] dataSession;
    Spinner spinner;
    TextView txtNamaPilkada;
    TextView txtTPS;
    TextView txtNamaLengkap;
    EditText txtTanggal;
    Button btnSave;
    HashMap<String, EditText> dataKandidat;

    @Nullable
    @Override
    public View onCreateView(LayoutInflater inflater, @Nullable ViewGroup container, Bundle savedInstanceState) {
        view = inflater.inflate(R.layout.fragment_result_input, container, false);

        spinner = (Spinner) view.findViewById(R.id.spinnerPutaran);
        txtNamaPilkada = (TextView) view.findViewById(R.id.txtNamaPilkada);
        txtTPS = (TextView) view.findViewById(R.id.txtTPS);
        txtNamaLengkap = (TextView) view.findViewById(R.id.txtNamaLengkap);
        txtTanggal = (EditText) view.findViewById(R.id.txtTanggal);
        btnSave = (Button) view.findViewById(R.id.btnSave);

        btnSave.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                try {
                    Iterator it = dataKandidat.entrySet().iterator();
                    while (it.hasNext()) {
                        Map.Entry pair = (Map.Entry) it.next();
                        Log.d("DATA",pair.getKey() + " = " + pair.getValue());
                        EditText tes = (EditText) pair.getValue();
                        new WebServiceSendData()
                                .setUrl(Config.baseURL + "/user/result")
                                .setData("pilkada_result_pilkada_candidate_id=" + pair.getKey() +
                                        "&pilkada_result_pilkada_session_id=" +
                                        "&pilkada_result_pilkada_tps_id=" + Config.surveyor.getSurveyor_pilkada_tps_id() +
                                        "&pilkada_result_total_vote=" + tes.getText().toString() +
                                        "&pilkada_result_imagepath=" +
                                        "&pilkada_result_create_user_id=" + Config.surveyor.getSurveyor_id() +
                                        "&pilkada_result_create_date=" +
                                        "&pilkada_result_status=" +
                                        "&pilkada_result_log_id=" +
                                        "&pilkada_result_pilkada_id=" + Config.surveyor.getSurveyor_pilkada_tps_id())// => String VALUES = "name=nameValue & surname=surnameValue & age=ageValue";
//                            .setData("pilkada_result_create_user_id=" + Config.surveyor.getSurveyor_id())// => String VALUES = "name=nameValue & surname=surnameValue & age=ageValue";
                                .setRequestMethod(MethodType.POST)
//                            .setRequestProperty(RequestPropertyType.MULTIPART_FORM_DATA)
                                .connect();
                        it.remove(); // avoids a ConcurrentModificationException
                    }
                } catch (IOException e) {
                    e.printStackTrace();
                }
            }
        });

        init();
        return view;
    }

    public void init() {
        try {
            String result = (String) new WebServiceSendData()
                    .setUrl(Config.baseURL + "/user/getSession")
                    .setData("pilkada_result_pilkada_id=" + Config.surveyor.getSurveyor_pilkada_tps_id())
                    .setRequestMethod(MethodType.POST)
                    .connect();

            Log.d("JSON GET", result);
            JSONObject dataAsliService = new JSONObject(result);
            if (dataAsliService != null) {
                JSONArray data = dataAsliService.getJSONArray("data_user");
                JSONArray data_kandidat = dataAsliService.getJSONArray("data_kandidat");
                JSONArray dataSession = dataAsliService.getJSONArray("data");
                JSONObject user = data.getJSONObject(0);

                this.dataSession = new String[dataSession.length()];
                for (int i = 0; i < dataSession.length(); i++) {
                    this.dataSession[i] = dataSession.getJSONObject(i).getString("pilkada_session_name");
                }

                ArrayAdapter<String> spinnerArrayAdapter = new ArrayAdapter<String>(view.getContext(), android.R.layout.simple_spinner_item, this.dataSession); //selected item will look like a spinner set from XML
                spinnerArrayAdapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
                spinner.setAdapter(spinnerArrayAdapter);

                txtNamaPilkada.setText(user.getString("pilkada_name"));
                txtTPS.setText(Config.surveyor.getSurveyor_pilkada_tps_id());
                txtNamaLengkap.setText(Config.surveyor.getSurveyor_fullname());

                dataKandidat = new HashMap<>();
                for (int i = 0; i < data_kandidat.length(); i++) {
                    JSONObject user2 = data_kandidat.getJSONObject(i);

                     /* Find Tablelayout defined in main.xml */
                    TableLayout tl = (TableLayout) view.findViewById(R.id.resultKandidat);
                    TableRow tr = new TableRow(view.getContext());
                    tr.setLayoutParams(new TableRow.LayoutParams(TableRow.LayoutParams.FILL_PARENT, TableRow.LayoutParams.WRAP_CONTENT));

                    TextView label = new TextView(view.getContext());
                    label.setText(user2.getString("pilkada_candidate_name"));
                    label.setLayoutParams(new TableRow.LayoutParams(TableRow.LayoutParams.FILL_PARENT, TableRow.LayoutParams.WRAP_CONTENT));
                    tr.addView(label);

                    EditText value = new EditText(view.getContext());
                    value.setHint("0");
                    value.setLayoutParams(new TableRow.LayoutParams(TableRow.LayoutParams.FILL_PARENT, TableRow.LayoutParams.WRAP_CONTENT));
                    tr.addView(value);
                    dataKandidat.put(user2.getString("pilkada_candidate_id"), value);

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
