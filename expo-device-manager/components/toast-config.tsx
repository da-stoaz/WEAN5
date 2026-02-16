import { BaseToast, ErrorToast, ToastConfig } from "react-native-toast-message";

export const toastConfig: ToastConfig = {
  success: (props) => (
    <BaseToast
      {...props}
      style={{
        borderLeftColor: "#0E9F6E",
        borderLeftWidth: 6,
        borderRadius: 14,
        backgroundColor: "#F7FFFC",
        width: "92%",
        zIndex: 9999,
        elevation: 9999,
      }}
      contentContainerStyle={{ paddingHorizontal: 14 }}
      text1Style={{
        fontSize: 14,
        fontWeight: "700",
        color: "#0B4734",
      }}
      text2Style={{
        fontSize: 12,
        color: "#275748",
      }}
    />
  ),
  error: (props) => (
    <ErrorToast
      {...props}
      style={{
        borderLeftColor: "#D12D4A",
        borderLeftWidth: 6,
        borderRadius: 14,
        backgroundColor: "#FFF8F9",
        width: "92%",
        zIndex: 9999,
        elevation: 9999,
      }}
      contentContainerStyle={{ paddingHorizontal: 14 }}
      text1Style={{
        fontSize: 14,
        fontWeight: "700",
        color: "#541522",
      }}
      text2Style={{
        fontSize: 12,
        color: "#703541",
      }}
    />
  ),
};
