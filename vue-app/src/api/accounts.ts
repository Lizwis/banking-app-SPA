import axiosInstance from './axios';

export default {
  listAccounts(): Promise<any> {
    return axiosInstance.get('/user/accounts/list');
  },

  singleAccount(id:any): Promise<any> {
    return axiosInstance.get(`/user/accounts/show/${id}`);
  },

  listTransection(id: any): Promise<any> {
    return axiosInstance.get(`/account/transactions/list/${id}`);
  },

  listTransectionPaginate(id: any, pageNum: any): Promise<any> {
    return axiosInstance.get(`/account/transactions/list/${id}?page=${pageNum}`);
  },


  createTransaction(form: any): Promise<any> {
    return axiosInstance.post(`/account/transactions/store`, form);
  }

  
}