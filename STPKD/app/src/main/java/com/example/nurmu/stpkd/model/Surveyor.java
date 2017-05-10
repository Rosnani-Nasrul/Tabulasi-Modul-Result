package com.example.nurmu.stpkd.model;

/**
 * Created by nurmu on 05/26/2017.
 */

public class Surveyor {

    String surveyor_id;
    String surveyor_pilkada_tps_id;
    String surveyor_nip;
    String surveyor_fullname;
    String surveyor_username;
    String surveyor_password;
    String surveyor_address;
    String surveyor_photo;
    String surveyor_phone;
    String surveyor_email;
    String surveyor_create_by;
    String surveyor_create_date;
    String surveyor_status;
    String surveyor_log_code;

    public Surveyor(String surveyor_id, String surveyor_pilkada_tps_id, String surveyor_nip, String surveyor_fullname, String surveyor_username, String surveyor_password, String surveyor_address, String surveyor_photo, String surveyor_phone, String surveyor_email, String surveyor_create_by, String surveyor_create_date, String surveyor_status, String surveyor_log_code) {
        this.surveyor_id = surveyor_id;
        this.surveyor_pilkada_tps_id = surveyor_pilkada_tps_id;
        this.surveyor_nip = surveyor_nip;
        this.surveyor_fullname = surveyor_fullname;
        this.surveyor_username = surveyor_username;
        this.surveyor_password = surveyor_password;
        this.surveyor_address = surveyor_address;
        this.surveyor_photo = surveyor_photo;
        this.surveyor_phone = surveyor_phone;
        this.surveyor_email = surveyor_email;
        this.surveyor_create_by = surveyor_create_by;
        this.surveyor_create_date = surveyor_create_date;
        this.surveyor_status = surveyor_status;
        this.surveyor_log_code = surveyor_log_code;
        this.surveyor_fullname = surveyor_fullname;
    }

    public String getSurveyor_id() {
        return surveyor_id;
    }

    public String getSurveyor_pilkada_tps_id() {
        return surveyor_pilkada_tps_id;
    }

    public String getSurveyor_nip() {
        return surveyor_nip;
    }

    public String getSurveyor_fullname() {
        return surveyor_fullname;
    }

    public String getSurveyor_username() {
        return surveyor_username;
    }

    public String getSurveyor_password() {
        return surveyor_password;
    }

    public String getSurveyor_address() {
        return surveyor_address;
    }

    public String getSurveyor_photo() {
        return surveyor_photo;
    }

    public String getSurveyor_phone() {
        return surveyor_phone;
    }

    public String getSurveyor_email() {
        return surveyor_email;
    }

    public String getSurveyor_create_by() {
        return surveyor_create_by;
    }

    public String getSurveyor_create_date() {
        return surveyor_create_date;
    }

    public String getSurveyor_status() {
        return surveyor_status;
    }

    public String getSurveyor_log_code() {
        return surveyor_log_code;
    }
}
