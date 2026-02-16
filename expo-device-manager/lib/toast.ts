import Toast from "react-native-toast-message";

export function showSuccess(message: string, detail?: string) {
  Toast.show({
    type: "success",
    text1: message,
    text2: detail,
    visibilityTime: 2600,
  });
}

export function showError(message: string, detail?: string) {
  Toast.show({
    type: "error",
    text1: message,
    text2: detail,
    visibilityTime: 3200,
  });
}
