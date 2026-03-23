import { MenuView } from "@react-native-menu/menu";
import { useEffect, useMemo, useState } from "react";
import {
  Pressable,
  SafeAreaView,
  ScrollView,
  StyleSheet,
  Text,
  TextInput,
  View,
} from "react-native";

import {
  getDefaultApiSettings,
  type ApiProtocol,
  useApiSettings,
} from "@/lib/api/settings";
import { showError, showSuccess } from "@/lib/toast";

const PROTOCOLS: ApiProtocol[] = ["http://", "https://"];

function parseHostAndPort(rawHost: string) {
  const cleaned = rawHost.trim().replace(/^https?:\/\//i, "").replace(/\/+$/, "");
  const portMatch = cleaned.match(/:(\d{1,5})$/);

  if (!portMatch) {
    return {
      host: cleaned,
      port: "",
    };
  }

  return {
    host: cleaned.slice(0, -portMatch[0].length),
    port: portMatch[1],
  };
}

function sanitizeHostInput(value: string) {
  return value
    .trim()
    .replace(/^https?:\/\//i, "")
    .replace(/\/+$/, "")
    .replace(/:(\d{1,5})$/, "");
}

export default function SettingsScreen() {
  const { protocol, host, setSettings, resetSettings } = useApiSettings();

  const [localProtocol, setLocalProtocol] = useState<ApiProtocol>(protocol);
  const [localHost, setLocalHost] = useState("");
  const [localPort, setLocalPort] = useState("");
  const [isSaving, setIsSaving] = useState(false);

  useEffect(() => {
    const parsed = parseHostAndPort(host);
    setLocalProtocol(protocol);
    setLocalHost(parsed.host);
    setLocalPort(parsed.port);
  }, [host, protocol]);

  const previewUrl = useMemo(() => {
    const hostPart = sanitizeHostInput(localHost);
    const portPart = localPort.trim();

    if (!hostPart) {
      return `${localProtocol}<host>${portPart ? `:${portPart}` : ""}`;
    }

    return `${localProtocol}${hostPart}${portPart ? `:${portPart}` : ""}`;
  }, [localHost, localPort, localProtocol]);

  async function handleSave() {
    const hostPart = sanitizeHostInput(localHost);
    const portPart = localPort.trim();

    if (!hostPart) {
      showError("Validation failed", "API host is required.");
      return;
    }

    if (portPart && !/^\d{1,5}$/.test(portPart)) {
      showError("Validation failed", "Port must be a number between 1 and 65535.");
      return;
    }

    const portNumber = Number(portPart);
    if (portPart && (portNumber < 1 || portNumber > 65535)) {
      showError("Validation failed", "Port must be in the range 1-65535.");
      return;
    }

    try {
      setIsSaving(true);
      await setSettings({
        protocol: localProtocol,
        host: portPart ? `${hostPart}:${portPart}` : hostPart,
      });
      showSuccess("Saved", "API configuration updated.");
    } catch (error) {
      const message = error instanceof Error ? error.message : "Please try again.";
      showError("Could not save settings", message);
    } finally {
      setIsSaving(false);
    }
  }

  async function handleReset() {
    const defaults = getDefaultApiSettings();
    const parsed = parseHostAndPort(defaults.host);

    setLocalProtocol(defaults.protocol);
    setLocalHost(parsed.host);
    setLocalPort(parsed.port);

    await resetSettings();
    showSuccess("Settings reset", "Restored default API endpoint.");
  }

  const protocolControl = (
    <View style={styles.protocolButton}>
      <Text style={styles.protocolText}>{localProtocol}</Text>
      <Text style={styles.chevron}>▾</Text>
    </View>
  );

  return (
    <SafeAreaView style={styles.screen}>
      <ScrollView contentContainerStyle={styles.content}>
        <Text style={styles.title}>Settings</Text>
        <Text style={styles.subtitle}>Configure how the app connects to your API.</Text>

        <View style={styles.card}>
          <Text style={styles.label}>Base URL</Text>
          <View style={styles.urlRow}>
            <MenuView
              style={styles.protocolMenu}
              title="Protocol"
              shouldOpenOnLongPress={false}
              actions={PROTOCOLS.map((value) => ({ id: value, title: value }))}
              onPressAction={({ nativeEvent }) => {
                if (
                  nativeEvent.event === "http://" ||
                  nativeEvent.event === "https://"
                ) {
                  setLocalProtocol(nativeEvent.event);
                }
              }}
            >
              {protocolControl}
            </MenuView>

            <View style={styles.verticalDivider} />

            <TextInput
              value={localHost}
              onChangeText={setLocalHost}
              style={styles.hostInput}
              autoCapitalize="none"
              autoCorrect={false}
              placeholder="10.0.2.2"
              placeholderTextColor="#64748B"
            />

            <View style={styles.verticalDivider} />

            <Text style={styles.portColon}>:</Text>
            <TextInput
              value={localPort}
              onChangeText={(value) => setLocalPort(value.replace(/[^0-9]/g, ""))}
              style={styles.portInput}
              keyboardType="number-pad"
              placeholder="5055"
              placeholderTextColor="#64748B"
              maxLength={5}
            />
          </View>

          <Text style={styles.previewLabel}>Current URL</Text>
          <Text style={styles.previewText}>{previewUrl}</Text>

          <View style={styles.actions}>
            <Pressable style={styles.secondaryButton} onPress={handleReset}>
              <Text style={styles.secondaryButtonText}>Reset</Text>
            </Pressable>

            <Pressable
              style={[styles.primaryButton, isSaving && styles.disabledButton]}
              onPress={handleSave}
              disabled={isSaving}
            >
              <Text style={styles.primaryButtonText}>
                {isSaving ? "Saving..." : "Save"}
              </Text>
            </Pressable>
          </View>
        </View>
      </ScrollView>
    </SafeAreaView>
  );
}

const styles = StyleSheet.create({
  screen: {
    flex: 1,
    backgroundColor: "#F4F8FB",
  },
  content: {
    padding: 16,
    gap: 14,
    paddingBottom: 24,
  },
  title: {
    fontSize: 30,
    fontWeight: "800",
    color: "#0F172A",
    letterSpacing: -0.6,
  },
  subtitle: {
    marginTop: -4,
    fontSize: 14,
    color: "#334155",
  },
  card: {
    borderRadius: 16,
    borderWidth: 1,
    borderColor: "#DCE7F3",
    backgroundColor: "#FFFFFF",
    padding: 14,
    gap: 10,
  },
  label: {
    fontSize: 13,
    fontWeight: "600",
    color: "#334155",
  },
  urlRow: {
    height: 48,
    borderRadius: 12,
    borderWidth: 1,
    borderColor: "#CBD5E1",
    backgroundColor: "#F8FAFC",
    flexDirection: "row",
    alignItems: "center",
    overflow: "hidden",
  },
  protocolButton: {
    width: "100%",
    height: 48,
    flexDirection: "row",
    alignItems: "center",
    justifyContent: "center",
    gap: 6,
    backgroundColor: "#F1F5F9",
  },
  protocolMenu: {
    width: 104,
    height: 48,
  },
  protocolText: {
    fontSize: 14,
    fontWeight: "700",
    color: "#0F172A",
  },
  chevron: {
    fontSize: 11,
    color: "#334155",
    marginTop: 1,
  },
  verticalDivider: {
    width: 1,
    alignSelf: "stretch",
    backgroundColor: "#CBD5E1",
  },
  hostInput: {
    flex: 1,
    height: 48,
    paddingHorizontal: 12,
    fontSize: 17,
    color: "#0F172A",
  },
  portColon: {
    marginLeft: 8,
    marginRight: 2,
    fontSize: 16,
    color: "#334155",
    fontWeight: "700",
  },
  portInput: {
    width: 66,
    height: 48,
    paddingRight: 10,
    fontSize: 17,
    color: "#0F172A",
  },
  previewLabel: {
    marginTop: 2,
    fontSize: 12,
    color: "#64748B",
    fontWeight: "600",
  },
  previewText: {
    fontSize: 14,
    color: "#0C4A6E",
    fontWeight: "600",
  },
  actions: {
    marginTop: 10,
    flexDirection: "row",
    justifyContent: "flex-end",
    gap: 10,
  },
  primaryButton: {
    minWidth: 88,
    borderRadius: 12,
    backgroundColor: "#0EA5A5",
    paddingVertical: 10,
    paddingHorizontal: 14,
    alignItems: "center",
  },
  primaryButtonText: {
    color: "#F8FAFC",
    fontSize: 14,
    fontWeight: "700",
  },
  secondaryButton: {
    borderRadius: 12,
    borderWidth: 1,
    borderColor: "#CBD5E1",
    backgroundColor: "#F8FAFC",
    paddingVertical: 10,
    paddingHorizontal: 14,
    alignItems: "center",
  },
  secondaryButtonText: {
    color: "#0F172A",
    fontSize: 13,
    fontWeight: "600",
  },
  disabledButton: {
    opacity: 0.6,
  },
});
