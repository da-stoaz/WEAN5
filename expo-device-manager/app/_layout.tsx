import MaterialCommunityIcons from "@expo/vector-icons/MaterialCommunityIcons";
import { QueryClientProvider } from "@tanstack/react-query";
import { NativeTabs, Icon, Label, VectorIcon } from "expo-router/unstable-native-tabs";
import { StatusBar } from "expo-status-bar";
import Toast from "react-native-toast-message";

import { toastConfig } from "@/components/toast-config";
import { ApiSettingsProvider } from "@/lib/api-settings";
import { queryClient } from "@/lib/query-client";

export default function RootLayout() {
  return (
    <QueryClientProvider client={queryClient}>
      <ApiSettingsProvider>
        <StatusBar style="dark" />
        <NativeTabs
          blurEffect="systemChromeMaterial"
          backgroundColor="rgba(245, 251, 252, 0.9)"
          tintColor="#0F172A"
          labelStyle={{
            color: "#334155",
            fontSize: 12,
            fontWeight: "600",
          }}
          iconColor={{
            default: "#6B7280",
            selected: "#0F172A",
          }}
          shadowColor="rgba(15, 23, 42, 0.12)"
          disableTransparentOnScrollEdge
        >
          <NativeTabs.Trigger name="devices">
            <Label>Devices</Label>
            <Icon
              src={{
                default: (
                  <VectorIcon
                    family={MaterialCommunityIcons}
                    name="tablet-dashboard"
                  />
                ),
                selected: (
                  <VectorIcon
                    family={MaterialCommunityIcons}
                    name="tablet-dashboard"
                  />
                ),
              }}
            />
          </NativeTabs.Trigger>

          <NativeTabs.Trigger name="settings">
            <Label>Settings</Label>
            <Icon
              src={{
                default: (
                  <VectorIcon family={MaterialCommunityIcons} name="cog-outline" />
                ),
                selected: <VectorIcon family={MaterialCommunityIcons} name="cog" />,
              }}
            />
          </NativeTabs.Trigger>
        </NativeTabs>

        <Toast
          config={toastConfig}
          position="bottom"
          bottomOffset={88}
          keyboardOffset={8}
          swipeable
          onPress={() => Toast.hide()}
        />
      </ApiSettingsProvider>
    </QueryClientProvider>
  );
}
