import Toast from "react-native-toast-message";

const TOAST_BOTTOM_OFFSET = 88;

export function showSuccess(message: string, detail?: string) {
  Toast.show({
    type: "success",
    text1: message,
    text2: detail,
    position: "bottom",
    bottomOffset: TOAST_BOTTOM_OFFSET,
    swipeable: true,
    onPress: () => Toast.hide(),
    visibilityTime: 2600,
  });
}

export function showError(message: string, detail?: string) {
  Toast.show({
    type: "error",
    text1: message,
    text2: detail,
    position: "bottom",
    bottomOffset: TOAST_BOTTOM_OFFSET,
    swipeable: true,
    onPress: () => Toast.hide(),
    visibilityTime: 3200,
  });
}
